<?php

abstract class PhabricatorProjectHeraldAction
  extends HeraldAction {

  const DO_ADD_PROJECTS = 'do.add-projects';
  const DO_REMOVE_PROJECTS = 'do.remove-projects';

  public function getActionGroupKey() {
    return HeraldSupportActionGroup::ACTIONGROUPKEY;
  }

  public function supportsObject($object) {
    return ($object instanceof PhabricatorProjectInterface);
  }

  public function supportsRuleType($rule_type) {
    return ($rule_type == HeraldRuleTypeConfig::RULE_TYPE_GLOBAL);
  }

  protected function applyProjects(array $phids, $is_add) {
    $adapter = $this->getAdapter();
    phlog("xxxxxxxxxxxxxxxx 1");

    $allowed_types = array(
      PhabricatorProjectProjectPHIDType::TYPECONST,
    );

    // Detection of "No Effect" is a bit tricky for this action, so just do it
    // manually a little later on.
    $current = array();

    phlog("xxxxxxxxxxxxxxxx 1.0");
    $targets = $this->loadStandardTargets($phids, $allowed_types, $current);
    phlog("xxxxxxxxxxxxxxxx 1.1");
    if (!$targets) {
      return;
    }

    phlog("xxxxxxxxxxxxxxxx 2");
    $phids = array_fuse(array_keys($targets));

    $project_type = PhabricatorProjectObjectHasProjectEdgeType::EDGECONST;
    $current = $adapter->loadEdgePHIDs($project_type);

    if ($is_add) {
      $already = array();
      foreach ($phids as $phid) {
        if (isset($current[$phid])) {
          $already[$phid] = $phid;
          unset($phids[$phid]);
        }
      }

      if ($already) {
        $this->logEffect(self::DO_STANDARD_NO_EFFECT, $already);
      }
    } else {
      $already = array();
      foreach ($phids as $phid) {
        if (empty($current[$phid])) {
          $already[$phid] = $phid;
          unset($phids[$phid]);
        }
      }

      if ($already) {
        $this->logEffect(self::DO_STANDARD_NO_EFFECT, $already);
      }
    }

    phlog("xxxxxxxxxxxxxxxx 3");
    if (!$phids) {
      return;
    }

    phlog("xxxxxxxxxxxxxxxx 4");
    if ($is_add) {
      $kind = '+';
    } else {
      $kind = '-';
    }
    phlog("xxxxxxxxxxxxxxxx 5");
    $xaction = $adapter->newTransaction()
      ->setTransactionType(PhabricatorTransactions::TYPE_EDGE)
      ->setMetadataValue('edge:type', $project_type)
      ->setNewValue(
        array(
          $kind => $phids,
        ));

    phlog("xxxxxxxxxxxxxxxx 6");
    $adapter->queueTransaction($xaction);

    phlog("xxxxxxxxxxxxxxxx 7");
    if ($is_add) {
      $this->logEffect(self::DO_ADD_PROJECTS, $phids);
    } else {
      $this->logEffect(self::DO_REMOVE_PROJECTS, $phids);
    }
  }

  protected function getActionEffectMap() {
    return array(
      self::DO_ADD_PROJECTS => array(
        'icon' => 'fa-briefcase',
        'color' => 'green',
        'name' => pht('Added Projects'),
      ),
      self::DO_REMOVE_PROJECTS => array(
        'icon' => 'fa-minus-circle',
        'color' => 'green',
        'name' => pht('Removed Projects'),
      ),
    );
  }

  protected function renderActionEffectDescription($type, $data) {
    switch ($type) {
      case self::DO_ADD_PROJECTS:
        return pht(
          'Added %s project(s): %s.',
          phutil_count($data),
          $this->renderHandleList($data));
      case self::DO_REMOVE_PROJECTS:
        return pht(
          'Removed %s project(s): %s.',
          phutil_count($data),
          $this->renderHandleList($data));
    }
  }

}
