<?
namespace Concrete\Core\Page\Workflow\Progress;
use \Concrete\Core\Workflow\Progress as WorkflowProgress;
class Progress extends WorkflowProgress {  
	
	protected $cID;

	public static function add(Workflow $wf, PageWorkflowRequest $wr) {
		$wp = parent::add('page', $wf, $wr);
		$db = Loader::db();
		$db->Replace('PageWorkflowProgress', array('cID' => $wr->getRequestedPageID(), 'wpID' => $wp->getWorkflowProgressID()), array('cID', 'wpID'), true);
		$wp->cID = $wr->getRequestedPageID();
		return $wp;
	}
	
	public function loadDetails() {
		$db = Loader::db();
		$row = $db->GetRow('select cID from PageWorkflowProgress where wpID = ?', array($this->wpID));
		$this->setPropertiesFromArray($row);		
	}
	
	public function delete() {
		parent::delete();
		$db = Loader::db();
		$db->Execute('delete from PageWorkflowProgress where wpID = ?', array($this->wpID));
	}
	
	public static function getList(Page $c, $filters = array('wpIsCompleted' => 0), $sortBy = 'wpDateAdded asc') {
		$db = Loader::db();
		$filter = '';
		foreach($filters as $key => $value) {
			$filter .= ' and ' . $key . ' = ' . $value . ' ';
		}
		$filter .= ' order by ' . $sortBy;
		$r = $db->Execute('select wp.wpID from PageWorkflowProgress pwp inner join WorkflowProgress wp on pwp.wpID = wp.wpID where cID = ? ' . $filter, array($c->getCollectionID()));
		$list = array();
		while ($row = $r->FetchRow()) {
			$wp = PageWorkflowProgress::getByID($row['wpID']);
			if (is_object($wp)) {
				$list[] = $wp;
			}
		}
		return $list;
	}

	public function getWorkflowProgressFormAction() {
		return REL_DIR_FILES_TOOLS_REQUIRED . '/' . DIRNAME_WORKFLOW . '/categories/page?task=save_workflow_progress&cID=' . $this->cID . '&wpID=' . $this->getWorkflowProgressID() . '&' . Loader::helper('validation/token')->getParameter('save_workflow_progress');
	}

	public function getPendingWorkflowProgressList() {
		$list = new PageWorkflowProgressList();
		$list->filter('wpApproved', 0);
		$list->sortBy('wpDateLastAction', 'desc');
		return $list;
	}
	
	
}