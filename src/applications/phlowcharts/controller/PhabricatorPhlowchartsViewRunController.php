<?php

final class PhabricatorPhlowchartsViewRunController extends PhabricatorFileController {

  public function shouldAllowPublic() {
    return true;
  }

  public function isGlobalDragAndDropUploadEnabled() {
    return true;
  }

  public function handleRequest(AphrontRequest $request) {
    return id(new PhabricatorPhlowchartsSearchEngine())
      ->setController($this)
      ->buildResponse();
  }
}