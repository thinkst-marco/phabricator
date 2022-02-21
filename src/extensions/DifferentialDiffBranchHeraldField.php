<?php

final class DifferentialDiffBranchHeraldField
  extends DifferentialDiffHeraldField {

  const FIELDCONST = 'differential.diff.branch';

  public function getHeraldFieldName() {
    return pht('Branch');
  }

  public function getHeraldFieldValue($object) {
    //$v =  base64_encode(print_r($object, true));
    //$myfile = @fopen("phlogs", "w") or die(print_r(error_get_last(),true));
    //fwrite($myfile, $v);
    //fclose($myfile);
    return $object->getBranch();
  }

  protected function getHeraldFieldStandardType() {
    return self::STANDARD_TEXT_LIST;
  }

}
