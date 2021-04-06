<?php

final class PhabricatorPhlowchartsEditFrameController
  extends PhabricatorPhlowchartsViewController {

  public function shouldAllowPublic() {
    return true;
  }

  public function handleRequest(AphrontRequest $request) {
    $id = $request->getURIData('id');
    $viewer = $request->getViewer();
    $file = id(new PhabricatorFileQuery())
      ->setViewer($viewer)
      ->withIDs(array($id))
      ->withIsDeleted(false)
      ->executeOne();
    if (!$file) {
      return new Aphront404Response();
    }
    $raw_data = $file->loadFileData();
    // print_r(get_class_methods(get_class($file)));
    // print_r($file);
    

    if ($request->isFormPost()) {
      // print_r('xxxxx');
      $phlowchart_data = explode(';', $request->getStr('phlowchart-data'));
      // print_r($phlowchart_data);
      if ($phlowchart_data[0] != 'data:image/svg+xml'){
        return new Aphront404Response();
      }
      $phlowchart_data = explode(',', $phlowchart_data[1]);
      // print_r($phlowchart_data);
      
      if ($phlowchart_data[0] != 'base64'){
        return new Aphront404Response();
      }
      
      $raw_data = base64_decode($phlowchart_data[1]);
      $engine = $file->instantiateStorageEngine();
      $storage_handle = $file->getStorageHandle();
    
      $format_key = $file->getStorageFormat();
      $format = PhabricatorFileStorageFormat::getFormat($format_key);
      $integrity_hash = $engine->newIntegrityHash($raw_data, $format);
      $file->setIntegrityHash($integrity_hash)->save();

      $blob = id(new PhabricatorFileStorageBlob())->load($storage_handle);
      $blob->setData($raw_data)->save();

    }
    Javelin::initBehavior('phlowcharts-base');
    $page = $this->buildStandardPageView();

    // $page->setGlyph("\xE2\x96\xA0");
    
    $input_id = celerity_generate_unique_node_id();
    $form = id(new AphrontFormView())
      ->setID('save-phlowchart')
      ->setUser($viewer)
      ->appendChild(
        phutil_tag(
          'input',
          array(
            'type' => 'hidden',
            'name' => 'phlowchart-data',
            'id'   => 'phlowchart-data',
          )))
      ->appendChild(
        id(new AphrontFormSubmitControl())
          ->setHidden(true)
          ->setValue(pht('Save')));
          
    $page->appendChild(
      phutil_tag(
        'iframe',
        array(
          'data-url'    => "https://www.draw.io/?embed=1&configure=1&ui=atlas&spin=1&modified=unsavedChanges&proto=json",
          'data-phlowchart' => 'data:image/svg+xml;base64,'.base64_encode($raw_data),
          'frameborder' => '0',
          'style'       => 'width: 100%; border:0;
          position:fixed;
          top:44px;
          left:0;
          right:0;
          bottom:0;
          width:100%;
          height:100%',
          'id'          => 'drawioeditor',
        '',
        )
      ),
      array(
        'title' => pht('Phlowcharts View'),
      )
    );
    $page->appendChild($form);


    $response = new AphrontWebpageResponse();
    $response
      ->addContentSecurityPolicyURI('script-src', 'https://www.draw.io')
      ->addContentSecurityPolicyURI('frame-src', 'https://www.draw.io')
      ->setFrameable(true)
      ->setContent($page->render());

      return $response;
 
  }
}

// $page = $this->buildStandardPageView();

// $page->setGlyph("\xE2\x96\xA0");
// $page->appendChild(phutil_tag(
//   'iframe',
//   array(
//     'src'         => "https://www.draw.io/?embed=1&ui=atlas&spin=1&modified=unsavedChanges&proto=json",
//     'frameborder' => '0',
//     'style'       => 'width: 100%; height: 800px;',
//   '',
//   )),
//   array(
//     'title' => pht('Phlowcharts View'),
//   )
// );

// $response = new AphrontWebpageResponse();
// $response
//   ->addContentSecurityPolicyURI('script-src', 'https://www.draw.io')
//   ->addContentSecurityPolicyURI('frame-src', 'https://www.draw.io')
//   ->setFrameable(true)
//   ->setContent($page->render());

//   return $response;


// return id(new AphrontWebpageResponse())
// ->addContentSecurityPolicyURI('script-src', 'https://www.draw.io')
// ->addContentSecurityPolicyURI('frame-src', 'https://www.draw.io')
// ->setFrameable(true)
// ->setContent(
// phutil_tag(
//   'iframe',
//   array(
//     'src'         => "https://www.draw.io/?embed=1&ui=atlas&spin=1&modified=unsavedChanges&proto=json",
//     'frameborder' => '0',
//     'style'       => 'width: 100%; height: 800px;',
//   '',
// )),
// array(
//   'title' => pht('Phlowcharts View'),
// ));