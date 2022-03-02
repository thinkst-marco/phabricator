<?php

final class PhabricatorTaskProjectRemoveHeraldAction
  extends PhabricatorTaskProjectHeraldAction {

  const ACTIONCONST = 'task.projects.remove';

  public function getHeraldActionName() {
    return pht('Remove projects from linked task');
  }

  public function applyEffect($object, HeraldEffect $effect) {
    $is_add = false;
    $this->tagTask($object, $effect, $is_add);
  }

  public function renderActionDescription($value) {
    return pht('Remove projects: %s.', $this->renderHandleList($value));
  }

}
