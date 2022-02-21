<?php

final class DifferentialRevisionTaskHeraldFieldGroup extends HeraldFieldGroup {

  const FIELDGROUPKEY = 'differential.revision.task';

  public function getGroupLabel() {
    return pht('Task Fields');
  }

  protected function getGroupOrder() {
    return 1000;
  }

}
