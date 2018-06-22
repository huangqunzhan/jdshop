<?php
namespace app\admin\controller;
use think\Db;
use think\Request;
use think\Session;

if(!isset($_SESSION['imgupload'])){
	session_start();
}


/**
* 商品添加列表
*/
class Goods extends Common
{
	//添加商品
	public function addgoods(){
		//防止用户上传图片后没有点击上传则点开别的操作。把之前上传的无效图片删除
		/*  ./是当前目录 
		    ../是上级目录
		    ../../是上级目录的上级目录
		    /是根目录
		*/ 
		    // dump($_SESSION['imgupload']);

		    if(cookie('imgupload')){
		    	$cookie_arr = unserialize(cookie('imgupload'));
		    	//dump($cookie_arr);die;
		    	foreach ($cookie_arr as $key => $value) {
		    		$url_pre=DS.'jdshop'.DS.'public';
		    		$url=str_replace($url_pre,'.',$value);
		    		if (file_exists($url)) {
		    			unlink($url);
		    		}
		    	}
		    }
		    // if (!empty($_SESSION['imgupload'])) {
		    // 	dump($_SESSION['imgupload']);
		    // }
		    // 		    //dump($_SESSION['imgupload']);die;
		    // if(!empty($_SESSION['imgupload'])){
		    // 	$cookie_arr = unserialize(cookie('imgupload'));
		    // 	//dump($cookie_arr);die;
		    // 	foreach ($_SESSION['imgupload'] as $key => $value) {
		    // 		$url_pre=DS.'jdshop'.DS.'public';
		    // 		$url=str_replace($url_pre,'.',$value);
		    // 		if (file_exists($url)) {
		    // 			unlink($url);
		    // 		}
		    // 	}
		    // }
		cookie('imgupload',null);

		unset($_SESSION['imgupload']) ;   
		if (Session::get('goods_thumb')!=null) {
			//dump(getcwd());
			//获取当前工作路径为'D:\wamp64\www\jdshop\public
			$url_pre=DS.'jdshop'.DS.'public';
			$url=str_replace($url_pre,'.',session('goods_thumb'));
			//dump($url);
				if(file_exists($url)){
					unlink($url);
				}
			//unlink(session('goods_thumb'));
		}
		//Session::set('goods_thumb',null);
		session('goods_thumb',null);
		$cate_select=Db::table('jdshop_cate')->order('cate_sort')->select();
		$cate_model=model('Cate');
		//$cate_list=$cate_model->getChildrenId($cate_select);
		//dump($cate_list);
		$cate_list1=$cate_model->getChildren($cate_select);
		//dump($cate_list1);
		$this->assign('cate_list1',$cate_list1);
		//$this->assign('cate_list',$cate_list);		
		return $this->fetch();
	}
	//更新缩略图
	public function uploadthumb(){
		//防止用户多次上传图片
		if (session('goods_thumb')!=null) {
			$url_pre = DS.'jdshop'.DS.'public';
			$url = str_replace($url_pre,'.',session('goods_thumb'));
			if (file_exists($url)) {
				unlink($url);
			}
		}
		//Session::set('goods_thumb',null);
		session('goods_thumb',null);
		//利用插件上传图片的方法
  		//获取表单上传文件 例如上传了001.jpg
	         $file = request()->file('goods_thumb');
	      	 //移动到框架应用根目录/public/uploads目录下
	         $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
	         if($info){
	    	       //成功上传后 获取上传信息
	    	       //输出jpg
	                 $address = DS.'jdshop'.DS.'public' . DS . 'uploads'.DS.$info->getSaveName();
	                 session('goods_thumb',$address);
	                //session('goods_thumb',$address);
	                //显示上传图片
	                 return $address;
	         }else{
	    	       //上传失败获取错误信息
	                 echo $file->getError();
	         }
	}
	//添加商品处理
	public function addhandle(){
		//dump($_SESSION['imgupload']);die;
		if(request()->post()){
			//$post_data=request()->post();
			$post_data=input('post.');
			$post_data['goods_thumb']=Session::get('goods_thumb');
			$post_data['goods_status']=isset($post_data['goods_status']) ? $post_data['goods_status'] : '0';
			$post_data['goods_pid']=isset($post_data['goods_pid']) ? $post_data['goods_pid'] : null;
			$post_data['goods_after_price']=empty($post_data['goods_after_price']) ? '0' : $post_data['goods_after_price'];
		}
		if($post_data['goods_after_price']!=0){
			if ($post_data['goods_price']<=$post_data['goods_after_price']) {
				unset($_SESSION['imgupload']);
				session('goods_thumb',null);
				$this->error('商品价格不能小于商品价格','goods/addgoods');
			}
		}

		if (!isset($_SESSION['imgupload'])) {
			session('goods_thumb',null);
			$this->error('请不要同时打开多个添加商品窗口或还没有上传商品细节图','goods/addgoods');
		}
		
		$imgupload=$_SESSION['imgupload'];
		
		$validate=validate('Addgoods');
		if (!$validate->check($post_data)) {
			session('goods_thumb',null);
			unset($_SESSION['imgupload']);
			$this->error($validate->getError(),'goods/addgoods');
		}
		
		
		//$post_data_array=array('goods_name'=>$post_data['goods_name'],'goods_thumb'=>$post_data['goods_thumb'],'goods_price'=>$post_data['goods_price'],'goods_after_price'=>$post_data['goods_after_price'],'goods_status'=>$post_data['goods_status'],'goods_sales'=>$post_data['goods_sales'],'goods_inventory'=>$post_data['goods_inventory'],'goods_pid'=>$post_data['goods_pid']);
		//dump($post_data_array);die;
		//insertGetId()成功返回一个主键值
		$goods_add=Db::table('jdshop_goods')->insertGetId($post_data);
		//dump($goods_add);die;
		if ($goods_add) {
			session('goods_thumb',null);
			$goods_model=model('Goods');
			$goods_id=$goods_model->get($goods_add);
			foreach ($imgupload as $key => $value) {
				if ($value!=0) {
					//添加细节图的时候检查是否有添加又删除的情况
					$goods_id->Img()->save(['url'=>$value]);
				}
				
			}
			unset($_SESSION['imgupload']);
			$this->success('商品添加成功','goods/goodslist');
			//不能放跳转语句下面，跳转后不执行
			//session('goods_thumb',null);
		}else{
			session('goods_thumb',null);
			unset($_SESSION['imgupload']);
			$this->error('添加商品失败','goodslist');
		}
	}

	//ajax取消上传缩略图
	public function cancleupload(){
		if (request()->isAjax()) {
			if(session('goods_thumb')!=null){
				//dump(session('goods_thumb'));
				$url_pre=DS.'jdshop'.DS.'public';
				$url=str_replace($url_pre,'.',session('goods_thumb'));
				if (file_exists($url)) {
					unlink($url);
				}
			}
			session('goods_thumb',null);
		}		
	}

	//商品列表
	public function goodslist1(){
		$goods_select=Db::table('jdshop_goods')
			->alias(['jdshop_goods'=>'a','jdshop_cate'=>'b'])
			->join('jdshop_cate','a.goods_pid=b.cate_id')
			->paginate(4);
		$this->assign('goods_select',$goods_select);
		return $this->fetch();
	}

	public function goodslist($goods_pid=''){
		$goods_model=model('Goods');
		// $goods_all=$goods_model->all();

		// dump($goods_all);die;
		// $goods_get=$goods_model->get(12);
		// $goods_keywords=collection($goods_get->keywords)->toArray();
		// dump($goods_keywords);die;
		//$goods_all=$goods_model->all();
		//dump($goods_all);die;
		

		// $cate_model=model('Cate');
		//all()相当与select()
		// $cate_all=$cate_model->all();
		// //toArray方法将当前的模型实例输出为数组
		// //collection设置模型数据集的返回类型
		// $cate_all_toArray=collection($cate_all)->toArray();
		// dump($cate_all_toArray);die;
		// dump($cate_all);die;

		$cate_select=Db::table('jdshop_cate')->order('cate_sort')->select();
		$cate_model=model('Cate');
		$cate_list1=$cate_model->getChildren($cate_select);
		//dump($cate_list1);die;
		$this->assign('cate_list1',$cate_list1);

		if($goods_pid==''){
			// $goods_select=Db::table('jdshop_goods')
			// 	->alias(['jdshop_goods'=>'a','jdshop_cate'=>'b'])
			// 	->join('jdshop_cate','a.goods_pid=b.cate_id')
			// 	->paginate(2);
			// $this->assign('goods_select',$goods_select);			
			$goods_all=$goods_model->all();
		}else{
			$goods_cate_find=Db::table('jdshop_cate')				
					->where('cate_id',$goods_pid)
					->select();
			//dump($goods_cate_find);die;
			if($goods_cate_find){
				// $goods_select=Db::table('jdshop_goods')
				// 	->alias(['jdshop_goods'=>'a','jdshop_cate'=>'b'])
				// 	->where('goods_pid',$goods_pid)
				// 	->join('jdshop_cate','a.goods_pid=b.cate_id')
				// 	->paginate(2);
				// $this->assign('goods_select',$goods_select);
				//$this->assign('goods_cate_find',$goods_cate_find);
				//带参数闭包查询
				$goods_all = $goods_model->all(function($query) use ($goods_pid){
		    			$query->where('goods_pid','eq',$goods_pid);
					});
			}
	}
	$goods_info=array();
		foreach ($goods_all as $key => $value) {

			$goods_get=$goods_model->get($value['goods_id']);
			//关联keywords数据表
			$goods_keywords=$goods_get->keywords;
			//dump($goods_keywords);die;
			$goods_keywords_toArray=collection($goods_keywords)->toArray();
			$value['keywords']=$goods_keywords_toArray;
			$goods_cate=$goods_get->cate;
			$goods_cate_toArray=$goods_cate->toArray();
			$value['cate']=$goods_cate_toArray;
			$goods_info[]=$value;
		}
		//dump($goods_info);die;
		$this->assign('goods_info',$goods_info);
		return $this->fetch();
	}

	//点击编辑商品列表展示信息
	public function updategoods($goods_id=''){
		//unset($_SESSION['imgupload']);
		//判断有没有参数传过来
		if($goods_id==''){
			$this->redirect('goodslist');
		}
		//如果有参数传过来的话，查看数据库是否存在
		$goods_id_data=Db::table('jdshop_goods')->where('goods_id',$goods_id)->find();
		if($goods_id_data==null){
			$this->redirect('goodslist');
		}
		if (session('goods_thumb')!=$goods_id_data['goods_thumb']){
			$url_pre = DS.'jd'.DS.'public';
			$url = str_replace($url_pre,'.',session('goods_thumb'));
			if (file_exists($url)) {
				unlink($url);
			}
		}
		session('goods_thumb',null);
		$this->assign('goods_id_data',$goods_id_data);
		
		$cate_select=Db::table('jdshop_cate')->order('cate_sort')->select();
		$cate_model=model('Cate');
		$cate_list1=$cate_model->getChildren($cate_select);

		$cate_list2=$cate_model->getFatherId($cate_select,$goods_id_data['goods_pid']);
		//$cate_list3=$cate_model->getFather($cate_select,$goods_id_data['goods_pid']);
		$cate_list2_data=array();
		$cate_list2_data['one']=$cate_list2['0'];
		$cate_list2_data['two']=$cate_list2['1'];
		$cate_list2_data['three']=$cate_list2['2'];
		//dump($cate_list2_data);
		//dump($cate_list1);die;
		$this->assign('cate_list2_data',$cate_list2_data);

		$img_exit=Db::table('jdshop_img')->where('goods_id',$goods_id)->select();
		//防止没修改就刷新
		if(isset($_SESSION['imgupload'])){
			foreach ($_SESSION['imgupload'] as $key => $value) {
				$url_pre=DS.'jdshop'.DS.'public';
				$url=str_replace($url_pre,'.',$value);
				if (file_exists($url)) {
					unlink($url);
				}
			}
		}
		unset($_SESSION['imgupload']);
		//清除细节图信息
		unset($_SESSION['old']);
		//清除旧图片信息
		foreach ($img_exit as $key => $value) {
			//老细节图全部等于1
			$_SESSION['imgupload'][]='1';
			//表明是旧的图片，不执行操作
			$_SESSION['old'][]=$value['url'];
		}
		//dump($img_exit);die;
		//dump($_SESSION['imgupload']);dump($_SESSION['old']);
		$this->assign('img_exit',$img_exit);		
		$this->assign('cate_list1',$cate_list1);
		return $this->fetch();
	}

	//编辑商品处理
	public function updategoodshandle(){
		if(request()->post()){
			$update_goods_data=input('post.');
			//dump($update_goods_data);die;
			if (session('goods_thumb')==null) {
				$update_goods_id_data=Db::table('jdshop_goods')->where('goods_id',$update_goods_data['goods_id'])->select();
				//dump($update_goods_id_data);die;
				$update_goods_data['goods_thumb']=$update_goods_id_data[0]['goods_thumb'];
			}
			if(session('goods_thumb')!=null){
				$update_goods_data['goods_thumb']=session('goods_thumb');
				session('goods_thumb',null);
				$update_goods_id_data=Db::table('jdshop_goods')->where('goods_id',$update_goods_data['goods_id'])->select();
				//dump($update_goods_id_data);
				$old_goods_thumbs=$update_goods_id_data[0]['goods_thumb'];
				//dump($old_goods_thumbs);
				//dump(getcwd());
				$url_pre=DS.'jdshop'.DS.'public';
				$url=str_replace($url_pre,'.',$old_goods_thumbs);
				if(file_exists($url)){
					unlink($url);
				}
			}
			//dump($update_goods_data);die;
			if($update_goods_data['goods_after_price']!=''){
				if($update_goods_data['goods_after_price']>=$update_goods_data['goods_price']){
					$this->error('商品促销价格不能大于原价','goods/goodslist');
				}
			}
			$update_goods_data=array('goods_id'=>$update_goods_data['goods_id'],'goods_name'=>$update_goods_data['goods_name'],'goods_thumb'=>$update_goods_data['goods_thumb'],'goods_price'=>$update_goods_data['goods_price'],'goods_after_price'=>$update_goods_data['goods_after_price'],'goods_status'=>$update_goods_data['goods_status'],'goods_sales'=>$update_goods_data['goods_sales'],'goods_inventory'=>$update_goods_data['goods_inventory'],'goods_pid'=>$update_goods_data['goods_pid']);
			//dump($update_goods_data);die;
			$validate = validate('Addgoods');
			if (!$validate->check($update_goods_data)) {
				$this->error($validate->getError(),'goods/goodslist');
			}
			$update_goods=Db::table('jdshop_goods')->where('goods_id',$update_goods_data['goods_id'])->update($update_goods_data);
			//dump($update_goods);die;
			if ($update_goods!==false) {
				//存在上传的新图和老细节图
				if(isset($_SESSION['imgupload'])){
					session('goods_thumb',null);
					$goods_model=model('Goods');
					$goods=$goods_model->get($update_goods_data['goods_id']);
					foreach ($_SESSION['imgupload'] as $key => $value) {
						//老细节图点击删除
						if($value == '-1'){
							//旧图片删除
							Db::table('jdshop_img')->where('url',$_SESSION['old'][$key])->delete();
							$url_pre=DS.'jdshop'.DS.'public';
							$url=str_replace($url_pre,'.',$_SESSION['old'][$key]);
							if (file_exists($url)) {
								unlink($url);
							}
							//$value!='1'&&$value!='0'说明是上传的新图
						}elseif ($value!='1'&&$value!='0') {
							//新增图片情况
							$goods->Img()->save(['url'=>$value]);
						}
						
					}
					unset($_SESSION['old']);
					unset($_SESSION['imgupload']);
					
				}
				$this->success('修改商品信息成功','goodslist');
			}else{
				unset($_SESSION['old']);
				unset($_SESSION['imgupload']);
				session('goods_thumb',null);
				$this->error('修改商品信息失败','goodslist');
				
			}

		}
	}

	//删除商品信息
	public function deletegood($goods_id=''){
		if ($goods_id=='') {
			$this->redirect('goodslist');
		}
		$goods_id_data=Db::table('jdshop_goods')->where('goods_id',$goods_id)->select();
		$goods_id_img=Db::table('jdshop_img')->where('goods_id',$goods_id)->field('url')->select();
		if ($goods_id_data==null) {
			$this->redirect('goodslist');
		}
		$goods_id_data_delete=Db::table('jdshop_goods')->where('goods_id',$goods_id)->delete();
		if ($goods_id_data_delete) {
			//dump($goods_id_data);
			$goods_thumb=$goods_id_data[0]['goods_thumb'];
			//dump($goods_thumb);
			//删除商品缩略图
			$url_pre=DS.'jdshop'.DS.'public';
			$url=str_replace($url_pre,'.',$goods_thumb);
			if (file_exists($url)) {
				unlink($url);
			}
			//删除商品关联关键字
			$goods_keywords_delete=Db::table('jdshop_goods_keywords')->where('goods_id',$goods_id)->delete();
			//删除商品细节图
			$url_pre=DS.'jdshop'.DS.'public';
			if (!empty($goods_id_img)) {
				foreach ($goods_id_img as $key => $value) {
					$url=str_replace($url_pre,'.',$value['url']);
					if (file_exists($url)) {
						unlink($url);
					}					
				}
			}
			//删除商品与细节图一对多关系
			$goods_img_delete=Db::table('jdshop_img')->where('goods_id',$goods_id)->delete();
			//可以直接把商品id与相关模型关联，直接删除商品id
			//删除属性名和商品属性
			$goodsproperty_delete=Db::table('jdshop_goodsproperty')->where('goods_id',$goods_id)->delete();
			//用或的原因是防止有的商品没有添加细节图或没有添加关键字
			if ($goods_keywords_delete || $goods_id_data_delete || $goods_img_delete || $goodsproperty_delete) {
				$this->success('删除商品信息成功','goods/goodslist');
			}
		}else{
			$this->error('删除商品信息失败','goods/goodslist');
		}
	}

	//关键字显示
	public function keywordsajax(){
	        if (request()->isAjax()) {
	            $post = request()->post();
	            $post_val = $post['val'];
	            //limit检索前三个
	            $keywords_like = db('keywords')->where('keywords_name','like','%'.$post_val.'%')->limit(3)->select();
	            return $keywords_like;
	        }
    	}

    	//关键字添加处理
    	public function keywordsaddhandle(){
    		$post=request()->post();
    		$goods_id=array_keys($post)[0];
    		$keywords_name=array_values($post)[0];
    		if(empty($keywords_name)){
    			$this->error('关键字不能为空','goods/goodslist');
    		}
    		$keywords_find=Db::table('jdshop_keywords')->where('keywords_name',$keywords_name)->select();
    		if (empty($keywords_find)) {
    			$this->error('关键字不存在,请先添加','keywords/addkeywords');
    		}
    		$keywords_id=$keywords_find[0]['keywords_id'];
    		$keywords_exit=Db::table('jdshop_goods_keywords')->where('goods_id',$goods_id)->where('keywords_id',$keywords_id)->select();
    		if ($keywords_exit) {
    			$this->error('该商品以存在该关键字','goods/goodslist');
    		}
    		$goods_model=model('Goods');
    		$goods_get=$goods_model->get($goods_id);
    		$a=$goods_get->keywords();
    		$goods_get->keywords()->attach($keywords_id);
    		$this->success('添加关键字成功','goods/goodslist');
    	}

    	//删除关键字
    	public function deletekeywords($goods_id='',$keywords_name=''){
    		if ($goods_id=='' || $keywords_name=='') {
    			$this->redirect('goods/goodslist');
    		}
    		$goods_id_find=Db::table('jdshop_goods')->where('goods_id',$goods_id)->select();
    		if (empty($goods_id_find)) {
    			$this->redirect('goods/goodslist');
    		}
    		$keywords_info=Db::table('jdshop_keywords')->where('keywords_name',$keywords_name)->select();
    		$keywords_name_id=$keywords_info[0]['keywords_id'];
    		$goods_model=model('Goods');
    		$goods_get=$goods_model->get($goods_id);
    		$goods_get->keywords()->detach($keywords_name_id);
    		$this->success('删除关键字成功','goods/goodslist');
    	}
    	//多张细节图上传
    	public function imgupload(){
    		//获取表单上传文件
	        $file = request()->file('goods_img');
	        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads'.DS.'img');
	        if($info){
	            $address = DS.'jdshop'.DS.'public' . DS . 'uploads'.DS.'img'.DS.$info->getSaveName();
	            $_SESSION['imgupload'][] = $address;
	            //返回值是一个字符串。有的时候为了把一些数据转为字符串存起来，但是希望保持数据原来有结构和内容
	            $session_str=serialize($_SESSION['imgupload']);
	            //cookie('imgupload',$session_str,3600);

	            cookie('imgupload',$session_str,3600);
	            return $address;
	        }else{
	            echo $file->getError();
	        }

   	 }
   	 //删除细节图
	public function imgcancle(){
	    if (request()->isAjax()) {
	         $post = request()->post();
	         $img_index = $post['index'];
	         $img_address = $_SESSION['imgupload'][$img_index];
	         //老细节图执行删除
	         if ($img_address=='1') {
	         		//老图片进行删除
	         		$_SESSION['imgupload'][$img_index]='-1';
	         }else{
	         		//新图上传又删除,不直接unset是要用作判断
	         		$_SESSION['imgupload'][$img_index]='0';
	         }
	         $url_pre = DS.'jdshop'.DS.'public';
	         $url = str_replace($url_pre,'.',$img_address);
	         if (file_exists($url)) {
	            unlink($url);
	         }
	    }
	}
	//添加商品属性
	public function addproperty($goods_id=''){
		if ($goods_id=='') {
			$this->redirect('goods/goodslist');
		}
		$goods_id_data=Db::table('jdshop_goods')->where('goods_id','eq',$goods_id)->find();
		if (empty($goods_id_data)) {
			$this->redirect('goods/goodslist');
		}
		$this->assign('goods_id_data',$goods_id_data);
		$property_pid=$goods_id_data['goods_pid'];
		$property_data=Db::table('jdshop_property')->where('property_pid','eq',$property_pid)->select();
		//dump($property_data);die;
		$goods_model=model('Goods');
		$goods=$goods_model->get($goods_id);
		$goodsproperty_select=$goods->goodsproperty()->select();
		$goodsproperty_select_toArray=$goodsproperty_select->toArray();
		$this->assign('goodsproperty_select_toArray',$goodsproperty_select_toArray);
		$this->assign('property_data',$property_data);
		return $this->fetch();
	}
	//添加商品属性处理
	public function addgoodspropertyhandle(){
		$post=request()->post();
		//dump($post);die;
		$goods_id=$post['goods_id'];
		//dump($goods_id);die;
		$goods_model=model('Goods');
		$goods=$goods_model->get($goods_id);
		$goodsproperty_select=$goods->goodsproperty()->select();
		$goodsproperty_select_toArray=$goodsproperty_select->toArray();
		//获取到指定商品id的属性id
		$goodsproperty_propertyid = array_column($goodsproperty_select_toArray,'property_id');
		//dump($goodsproperty_select_toArray);
		//dump($goodsproperty_propertyid);die;
		foreach ($post as $key => $value) {
			/**
			提交数据的四种情况
			1、原有属性已存在，新的属性不为空。进行更新。
			2、原有属性已存在，新的属性为空，进行删除。
			3、原有属性不存在，新的属性不为空，进行添加。
			4、原有属性不存在，新的属性为空，do nothing。
			*/
			//$post里面含有'goods_id'和'goods_name'字段
			if($key!='goods_id'&&$key!='goods_name'){
				//$goods->goodsproperty()->save(['property_id'=>$key,'goodsproperty_content'=>$value]);
				//数组匹配,提交数据项已存在，进行更新
				if (in_array($key, $goodsproperty_propertyid)) {
					//dump(in_array($key, $goodsproperty_propertyid));
					if ($value=='') {
						//数据为空的时候删除删除数据
						Db::table('jdshop_goodsproperty')->where(['property_id'=>$key,'goods_id'=>$goods_id])->delete();
					}else{
						//数据不为空的时候进行数据的更新
						Db::table('jdshop_goodsproperty')->where(['property_id'=>$key,'goods_id'=>$goods_id])->update(['goodsproperty_content'=>$value]);
					}
				}else{
					//提交一个新的数据项，进行添加,新添加的属性
					if ($value!='') {
						$goods->goodsproperty()->save(['property_id'=>$key,'goodsproperty_content'=>$value]);
					}
				}
			}
		}
		$this->redirect('goods/goodslist');
	}
}
?>
