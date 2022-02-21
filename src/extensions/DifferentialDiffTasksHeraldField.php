<?php

final class DifferentialDiffBranchTaskHeraldField
  extends DifferentialDiffHeraldField {

  const FIELDCONST = 'differential.diff.branchtask';

  public function getHeraldFieldName() {
    return pht('Branch Task');
  }

  public function getHeraldFieldValue($object) {
    $adapter = $this->getAdapter();
    $viewer = $adapter->getViewer();
    //$v =  base64_encode(print_r($object, true));
    //$myfile = @fopen("phlogs", "w") or die(print_r(error_get_last(),true));
    //fwrite($myfile, $v);
    //fclose($myfile);
    phlog("XXXXXXXXXXX 1");
    $branch = $object->getBranch();
    phlog("XXXXXXXXXXX 2");
    $exp = "/^t([0-9]+)[^0-9]*/i";
    phlog("XXXXXXXXXXX 3");
    if (!preg_match($exp, $branch, $matches)) {
    		phlog("XXXXXXXXXXX no task");
	    return array();
    }
    phlog("XXXXXXXXXXX 4");
    $task_id = (int)$matches[1];
    phlog("XXXXXXXXXXX ".$task_id);
    phlog("XXXXXXXXXXX 5");
    $task = id(new ManiphestTaskQuery())
      ->setViewer($viewer)
      ->withIDs(array($task_id))
      ->executeOne();
    phlog("XXXXXXXXXXX 6");
    phlog($task);
    phlog("XXXXXXXXXXX 7");
    return $task;

  }

  protected function getHeraldFieldStandardType() {
    return self::STANDARD_PHID_BOOL;
  }

}
