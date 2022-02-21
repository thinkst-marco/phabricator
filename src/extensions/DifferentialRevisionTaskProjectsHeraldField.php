<?php

final class DifferentialRevisionTaskProjectsHeraldField
  extends DifferentialRevisionHeraldField {

  const FIELDCONST = 'differential.revision.task.projects';

  public function getHeraldFieldName() {
    return pht('Task Projects');
  }

  public function getHeraldFieldValue($object) {
    //$v =  base64_encode(print_r($object, true));
    //$myfile = @fopen("phlogs-revision.task.projects", "w") or die(print_r(error_get_last(),true));
    //fwrite($myfile, $v);
    //fclose($myfile);
    $task_phids = PhabricatorEdgeQuery::loadDestinationPHIDs(
      $object->getPHID(),
      DifferentialRevisionHasTaskEdgeType::EDGECONST);
//    $task_phids = array_fuse($task_phids);
    if (count($task_phids) == 0) {
	    return array();
    }

    //phlog("XXXXXXXXXXX 2");
    //phlog(count($task_phids));
    //phlog(print_r($task_phids, true));
    //phlog("XXXXXXXXXXX 3");

    $project_phids = PhabricatorEdgeQuery::loadDestinationPHIDs(
      $task_phids[0],
      PhabricatorProjectObjectHasProjectEdgeType::EDGECONST);
    return $project_phids;
  }

  protected function getHeraldFieldStandardType() {
    return self::STANDARD_PHID_LIST;
  }

  protected function getDatasource() {
    return new PhabricatorProjectDatasource();
  }

  public function getFieldGroupKey() {
    return DifferentialRevisionTaskHeraldFieldGroup::FIELDGROUPKEY;
  }
}
