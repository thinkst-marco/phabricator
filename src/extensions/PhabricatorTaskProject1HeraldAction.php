<?php

abstract class PhabricatorTaskProjectHeraldAction
  extends PhabricatorProjectHeraldAction {

  public function tagTask($object, HeraldEffect $effect, $is_add) {
    $adapter = $this->getAdapter();

    $viewer = id(new PhabricatorUser())->loadOneWhere(
      'phid = %s',
      $object->getAuthorPHID());

    $task_phids = PhabricatorEdgeQuery::loadDestinationPHIDs(
      $object->getPHID(),
      DifferentialRevisionHasTaskEdgeType::EDGECONST);
    $task_id = $task_phids[0];
    $projects_fused_phids = array_fuse($effect->getTarget());
  
    if (count($task_phids) == 0) {
	    return array();
    }
 
    if ($is_add) {
      $kind = '+';
    } else {
      $kind = '-';
    }

    $transactions = array();
    $transactions[] = id(new ManiphestTransaction())
         ->setTransactionType(PhabricatorTransactions::TYPE_EDGE)
        ->setMetadataValue(
          'edge:type',
          PhabricatorProjectObjectHasProjectEdgeType::EDGECONST)
        ->setNewValue(
          array(
            $kind => $projects_fused_phids,
          ));
    
    $task = id(new ManiphestTaskQuery())
          ->setViewer($viewer)
          ->withPHIDs($task_phids)
          ->executeOne();

    $editor = id(new ManiphestTransactionEditor())
      ->setActor($viewer)
      ->setContentSource($adapter->getContentSource())
      ->setContinueOnNoEffect(true)
      ->setContinueOnMissingFields(true)
      ->applyTransactions($task, $transactions);

    if ($is_add) {
      $this->logEffect(self::DO_ADD_PROJECTS, $projects_fused_phids);
    } else {
      $this->logEffect(self::DO_REMOVE_PROJECTS, $projects_fused_phids);
    }
  }

  public function getHeraldActionStandardType() {
    return self::STANDARD_PHID_LIST;
  }

  protected function getDatasource() {
    return new PhabricatorProjectDatasource();
  }

}
