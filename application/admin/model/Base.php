<?php
/**
 * User: xiaomin
 * Date: 2019/11/7
 * Time: 23:08
 */

namespace app\admin\model;


use think\Model;

class Base extends Model
{
    protected $autoWriteTimestamp= true;

    /**新增
     * @param $data
     * @return false|int
     * @throws \Exception
     */
        public function add($data){
            if (!is_array($data)){
                exception("传递的数据错误");
            }
            $id = $this->allowField(true)->save($data);
            return $id;

        }

}