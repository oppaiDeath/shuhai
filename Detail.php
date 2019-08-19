<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\Book;
use app\index\model\Collect as CollectModel;
use think\Db;

class Detail extends Controller
{
    public function Detail()
    {
        $book=Book::where('bookID',input('get.bookID'))->find();
        $this->assign('book',$book);
        return $this->fetch();
    }
    public function addCollect()
    {
        $book=Book::where('bookID',input('get.bookID'))->find();
        if(empty(session('email'))){
        }

        $bookID=input('post.bookID');
        $bname=input('post.bname');
        $price=input('post.price');
        if(empty($bookID)||empty($bname)||empty($price))
        {
            return;
        }
        $collect=CollectModel::where('email',session('email'))->where('bookID',$bookID)->find();
        if(empty($collect))
        {
            Db::execute("insert into collect values('".session('email')."','".$bookID."','".$bname."','".$price."')");
            return ;
        }
        else {
            $collect->delete();
            return ;
        }
    }
    public function checkCollect()
    {
        if (empty(session('email')))
            return false;
        $bookID=input('post.bookID');
        $collect=CollectModel::where('email',session('email'))->where('bookID',$bookID)->find();
        if (empty($collect))
        {
            return false;
        }
        return true;
    }
}
