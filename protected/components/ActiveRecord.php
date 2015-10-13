<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class ActiveRecord extends CActiveRecord
{
	/**
	 * 下拉选项
	 * 
	 * @return boolean
	 */
	protected static $_items;

    /**
     * 返回参数
     * @return string
     */
    public function property($models)
    {
        if(!$models)return array();

        $items =array();
        foreach($models as $data)
        {
            $item = $data->attr();
            if($item)
                $items[] = $item;
        }

        return $items;
    }


    /**
	 * 查询列表
	 * @params array 查询条件
	 * @return model
	 */
	public function lists($params=array(), $condition='')
	{
		$size=10;
		$page=0;
		$order = $this->getTableSchema()->primaryKey.' DESC';
        $group = '';
        $subtotal = '';
		if(isset($params['other']))
		{
			$other = $params['other'];
			if(isset($other['size']))$size = intval($other['size']);
			if(isset($other['page']))$page = intval($other['page']);
            if(isset($other['order'])&&!empty($other['order']))$order = $other['order'];
            if(isset($other['group'])&&!empty($other['group']))$group = $other['group'];
            if(isset($other['subtotal'])&&!empty($other['subtotal']))$subtotal = $other['subtotal'];
		}
		
		$condition = $this->getCondition($params).$condition;

        if($group)
        {
            $total = intval($this->countBySql('SELECT COUNT(*) from (SELECT COUNT(*) FROM '.$this->tableName().' t WHERE '.$condition.' GROUP BY t.'.$group.') as t2'));
        }
        else
		    $total = intval($this->count($condition));
		$extra = array(
			'total'=>$total,
			'pages'=>ceil($total/$size),
			'page'=>$page,
			'size'=>$size,
            'subtotal'=>0,
		);

        if($subtotal)
        {
            $extra['subtotal'] = floatval($this->countBySql('SELECT IFNULL(SUM('.$subtotal.'),0) as PV FROM '.$this->tableName() .' t WHERE '.$condition));
        }

		$data = $this->property($this->findAll(array(
			'condition' => $condition,
			'offset' => $page*$size,
			'limit' => $size,
			'order' => $order,
            'group' => $group,
		)));

        return array('data'=>$data,'extra'=>$extra);
	}

	/**
	 * 查询列表
	 * @params array 查询条件
	 * @return model
	 */
	public function all($params=array(), $condition='')
	{
        $order = $this->getTableSchema()->primaryKey;
        $group = '';
        if(isset($params['other']))
        {
            $other = $params['other'];
            if(isset($other['order'])&&!empty($other['order']))$order = $other['order'];
            if(isset($other['group'])&&!empty($other['group']))$group = $other['group'];
        }

		$data = $this->property($this->findAll(array(
			'condition' => $this->getCondition($params).$condition,
			'order' => $order,
            'group' => $group,
        )));

		$extra = array(
			'total'=>count($data),
			'pages'=>0,
			'page'=>0,
			'size'=>0,
			'subtotal'=>0,
		);
		return array('data'=>$data,'extra'=>$extra);
	}

	/**
	 * 将参数组合为查询条件
	 * @return string
	 */
    public function getCondition($params)
    {
		$condition =' 1= 1 ';
		foreach($params as $key => $val)
		{
			if($key == 'other')
				continue;
			if($key == 'like')
			{
				if(is_array($val))
				{
                    $like = '';
					foreach($val as $k=>$q)
					{
						if($q)
                        {
                            if($like)
                                $like .= " or `t`.`$k` like '%$q%'";
                            else
                                $like = " `t`.`$k` like '%$q%'";
                        }
					}
                    if($like)
                        $condition .= ' and ('.$like.')';
				}
			}
			elseif($key == 'between')
			{
				if(is_array($val))
				{
					foreach($val as $k=>$v)
					{
						if(isset($v['min']) && isset($v['max']) && is_int($v['min']) && is_int($v['max']))
							$condition .= " and `t`.`$k` between ".$v['min']." and ".$v['max'];
							
						if(isset($v['start']) && isset($v['end']) && strlen($v['start'])==10 && strlen($v['end'])==10)
							$condition .= " and `t`.`$k` between '".$v['start']." 00:00:00' and '".$v['end']." 23:59:59'";
					}
				}
			}
			elseif($key=='>')
			{
				foreach($val as $k=>$v)
					$condition .= ' and `t`.`'.$k ."`>'".$v."'";
			}
			elseif($key=='<')
			{
				foreach($val as $k=>$v)
					$condition .= ' and `t`.`'.$k ."`<'".$v."'";
			}
			elseif(!empty($val) && is_string($val))
				$condition .= ' and `t`.`'.$key ."`='".$val."'";
			elseif(!empty($val) && is_array($val))
				$condition .= ' and `t`.`'.$key ."` in ('".join("','",$val)."')";
			elseif(is_int($val) && $val>0)
				$condition .= ' and `t`.`'.$key .'`='.$val;
		}

		return $condition;
    }

    /**
	 * 返回参数
	 * @return string
	 */
    public function attr()
    {
		return $this->attributes;
	}

	/**
	 * 获取一个不为空的对象
	 * @param int $id
	 * @return model
	 */
	public function a($id)
	{
		$model = $this->findByPk($id);
		if(!$model)$model = $this;
		return $model;
	}


}