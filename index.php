<?php
/**
 * Created by PhpStorm.
 * User: HXF
 * Date: 2017/4/10
 * Time: 11:17
 */

namespace think;


class index
{
    public function demo()
    {
        $where = '1=1';
        $cnt = $this->demoCnt($where);
        // 实例化分页类
        $page = $this->getPage($cnt[0]['cnt'], $where, '/index/demo');

        $data = $this->demoList($where,$page['firstRow'], $page['listRows']);

        return ['data' => $data, 'page' => $page['show']];
    }
    /**
     *分页公共函数
     */
    public function getPage($count,$where,$thisUrl)
    {
        // 实例化分页类 传入总记录数和每页显示的记录数(20)
        $Page = new \think\Page($count,config('paginate.page_size'));
        $Page->setConfig('header','共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;每页<b>20</b>条&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页&nbsp;&nbsp;');
        $Page->setConfig('theme','%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->setConfig('first','首页');
        $Page->setConfig('last','末页');
        $Page->setConfig('url',$thisUrl);
        //分页跳转的时候保证查询条件
        if(is_array($where))
        {
            foreach($where as $key=>$val)
            {
                $Page->parameter[$key] = urlencode($val);
            }
        }
        $show = $Page->show();// 分页显示输出
        return ['show' => $show,'firstRow' => $Page->firstRow,'listRows' => $Page->listRows];
    }
    public function demoCnt($where)
    {
        $sql = "SELECT count(1) as cnt from demo where $where";
        return Db::query($sql);
    }

    public function demoList($where, $firstRow, $listRows)
    {
        $sql = "SELECT * from demo where $where limit $firstRow,$listRows";
        return Db::query($sql);
    }
}