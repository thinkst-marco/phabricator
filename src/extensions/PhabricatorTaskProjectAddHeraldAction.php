<?php

final class PhabricatorTaskProjectAddHeraldAction
  extends PhabricatorTaskProjectHeraldAction {

  const ACTIONCONST = 'task.projects.add';

  public function getHeraldActionName() {
    return pht('Add projects to linked task');
  }

  public function applyEffect($object, HeraldEffect $effect) {
    $is_add = true;
    $this->tagTask($object, $effect, $is_add);
  }

  public function renderActionDescription($value) {
    return pht('Add projects: %s.', $this->renderHandleList($value));
  }

}
