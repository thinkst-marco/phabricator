<?php

abstract class PhabricatorPhlowchartsViewController extends PhabricatorController {

  public function buildStandardPageResponse($view, array $data) {
    $page = $this->buildStandardPageView();

    $page->setApplicationName('PhlowchartsView');
    $page->setBaseURI('/phlowcharts/');
    $page->setTitle(idx($data, 'title'));
    $page->setGlyph("\xE2\x96\xA0");
    $page->appendChild($view);

    $response = new AphrontWebpageResponse();
    return $response->setContent($page->render());
  }

}
