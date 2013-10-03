<?php

class Model_DbTable_Activity extends Zend_Db_Table
{
    protected $_name    = 'Activity';
    protected $_primary = 'ID';
    
    public function getLatest()
    {
    	$select = $this->_db->select()
    	->from($this->_name)
    	->order('ID DESC')
    	->limit(10);
    	return $this->_db->fetchAll($select);
    }
    public function getRecentActivity()
        {
            $query="select a.*,acc.ID as account_id,
            concat(ua.FIRST_NAME,' ',ua.LAST_NAME) as approved_name,ua.EMAIL_ADDRESS as approved_email,
            concat(ur.FIRST_NAME,' ',ur.LAST_NAME) as requested_name,ur.EMAIL_ADDRESS as requested_email,
            concat(un.FIRST_NAME,' ',un.LAST_NAME) as new_agent_name,un.EMAIL_ADDRESS as new_agent_email,
            ar.id as real_estate_account_id,r.O_COMPANY
             from Activity a
                    left join Mall m on m.id=a.mall_id
                    left join Account acc on acc.TARGET_ID=m.id
                    left join User ua on ua.id=a.APPROVED_BY
                    left join User ur on ur.id=a.Requested_by
                    left join User un on un.id=a.new_agent_id
                    left join Account ar on ar.TARGET_ID=a.REQUESTED_BY_REAL_ESTATE
                    left join Real_Estate r on r.id=a.REQUESTED_BY_REAL_ESTATE
                    ORDER BY a.UPDATED_ON DESC";
            return $this->_db->fetchAll($query);
        }
}