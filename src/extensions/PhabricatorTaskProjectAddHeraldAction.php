<?php

final class PhabricatorProjectAddHeraldAction
  extends PhabricatorProjectHeraldAction {

  const ACTIONCONST = 'task.projects.add';

  public function getHeraldActionName() {
    return pht('Add projects to linked task');
  }

  public function applyEffect($object, HeraldEffect $effect) {
    phlog("XXXXXXXXXXX 1");
    $v =  base64_encode(print_r($effect, true));
    $myfile = @fopen("phlogs-task.projects.add-effect", "w") or die(print_r(error_get_last(),true));
    fwrite($myfile, $v);
    fclose($myfile);
    $v =  base64_encode(print_r($this->getAdapter(), true));
    $myfile = @fopen("phlogs-task.projects.add-object", "w") or die(print_r(error_get_last(),true));
    fwrite($myfile, $v);
    fclose($myfile);

    phlog("XXXXXXXXXXX 2");

$task_phids = PhabricatorEdgeQuery::loadDestinationPHIDs(
      $object->getPHID(),
      DifferentialRevisionHasTaskEdgeType::EDGECONST);
//    $task_phids = array_fuse($task_phids);
    phlog("XXXXXXXXXXX 3");
    if (count($task_phids) == 0) {
	    return array();
    }
    phlog("XXXXXXXXXXX 4: ".count($task_phids));

//    $ret = $this->applyProjects($task_phids, $is_add = true);
    $effect->setObjectPHID($task_phids[0]);
    $ret = $this->applyProjects($effect->getTarget(), $is_add = true);
    phlog("XXXXXXXXXXX 5: ".$ret);
    return $ret;
  }

  public function getHeraldActionStandardType() {
    return self::STANDARD_PHID_LIST;
  }

  protected function getDatasource() {
    return new PhabricatorProjectDatasource();
  }

  public function renderActionDescription($value) {
    return pht('Add projects: %s.', $this->renderHandleList($value));
  }

}
