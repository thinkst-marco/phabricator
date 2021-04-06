<?php

final class PhabricatorPhlowchartsApplication extends PhabricatorApplication {

  public function getName() {
    return pht('Phlowcharts');
  }

  public function getBaseURI() {
    return '/phlowcharts/';
  }

  public function getIcon() {
    return 'fa-sitemap';
  }

  public function getShortDescription() {
    return pht('Flowcharts');
  }

  public function getTitleGlyph() {
    return "\xE2\x96\xA0";
  }

  public function getApplicationGroup() {
    return self::GROUP_DEVELOPER;
  }

  public function getRoutes() {
    return array(
      '/phlowcharts/' => array(
        '' => 'PhabricatorPhlowchartsViewRunController',
        '(query/(?P<queryKey>[^/]+)/)?' => 'PhabricatorPhlowchartsViewRunController',
        'edit/F(?P<id>[1-9]\d*)/'
          => 'PhabricatorPhlowchartsEditFrameController',
        'create/'
          => 'PhabricatorPhlowchartUploadDialogController',
      ),
    );
  }

}
