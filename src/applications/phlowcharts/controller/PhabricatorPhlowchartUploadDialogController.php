<?php

final class PhabricatorPhlowchartUploadDialogController
  extends PhabricatorFileController {

  public function handleRequest(AphrontRequest $request) {
    $viewer = $request->getViewer();

    $e_file = true;
    $errors = array();
    if ($request->isDialogFormPost()) {
      $chartname = $request->getStr('name');
      $view_policy = PhabricatorPolicies::POLICY_PUBLIC;
      $params = array(
        'authorPHID' => $viewer->getPHID(),
        'canCDN' => true,
        'name' => $chartname.'.svg',
      );
      $author = $viewer->getUsername();
      $date = date("Y/m/d");
      $source_template = '%3CmxGraphModel%20dx%3D%22642%22%20dy%3D%22442%22%20grid%3D%221%22%20gridSize%3D%2210%22%20guides%3D%221%22%20tooltips%3D%221%22%20connect%3D%221%22%20arrows%3D%221%22%20fold%3D%221%22%20page%3D%221%22%20pageScale%3D%221%22%20pageWidth%3D%22850%22%20pageHeight%3D%221100%22%20math%3D%220%22%20shadow%3D%220%22%3E%3Croot%3E%3CmxCell%20id%3D%220%22%2F%3E%3CmxCell%20id%3D%221%22%20parent%3D%220%22%2F%3E%3CmxCell%20id%3D%22qSaUCx_UHR85Xqd932O6-3%22%20value%3D%22%26lt%3Bdiv%20style%3D%26quot%3Bwhite-space%3A%20normal%26quot%3B%26gt%3B%26lt%3Bb%26gt%3B%26lt%3Bfont%20style%3D%26quot%3Bfont-size%3A%2015px%26quot%3B%26gt%3BTITLE%26lt%3B%2Ffont%26gt%3B%26lt%3B%2Fb%26gt%3B%26lt%3B%2Fdiv%26gt%3B%26lt%3Bdiv%20style%3D%26quot%3Bwhite-space%3A%20normal%26quot%3B%26gt%3BAuthor%3A%20AUTHOR%26lt%3B%2Fdiv%26gt%3B%26lt%3Bdiv%20style%3D%26quot%3Bwhite-space%3A%20normal%26quot%3B%26gt%3BDate%3A%20DATE%26lt%3B%2Fdiv%26gt%3B%26lt%3Bdiv%20style%3D%26quot%3Bwhite-space%3A%20normal%26quot%3B%26gt%3BRevision%3A%201%26lt%3B%2Fdiv%26gt%3B%26lt%3Bdiv%20style%3D%26quot%3Bwhite-space%3A%20normal%26quot%3B%26gt%3B%26lt%3Bbr%26gt%3B%26lt%3B%2Fdiv%26gt%3B%26lt%3Bdiv%20style%3D%26quot%3Bwhite-space%3A%20normal%26quot%3B%26gt%3B%26lt%3Bb%26gt%3BChangelog%26lt%3B%2Fb%26gt%3B%26lt%3B%2Fdiv%26gt%3B%26lt%3Bdiv%20style%3D%26quot%3Bwhite-space%3A%20normal%26quot%3B%26gt%3B%26lt%3Bbr%26gt%3B%26lt%3B%2Fdiv%26gt%3B%26lt%3Bdiv%20style%3D%26quot%3Bwhite-space%3A%20normal%26quot%3B%26gt%3BRev%201%3A%20Initial%20flowchart%26lt%3B%2Fdiv%26gt%3B%26lt%3Bdiv%26gt%3B%26lt%3Bbr%26gt%3B%26lt%3B%2Fdiv%26gt%3B%22%20style%3D%22rounded%3D0%3BwhiteSpace%3Dwrap%3Bhtml%3D1%3Balign%3Dleft%3BfillColor%3D%23dae8fc%3BstrokeColor%3D%236c8ebf%3B%22%20vertex%3D%221%22%20parent%3D%221%22%3E%3CmxGeometry%20x%3D%2210%22%20y%3D%2210%22%20width%3D%22230%22%20height%3D%22170%22%20as%3D%22geometry%22%2F%3E%3C%2FmxCell%3E%3C%2Froot%3E%3C%2FmxGraphModel%3E';
      $body_template = '<?xml version="1.0" encoding="UTF-8"?>
      <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
      <svg xmlns="http://www.w3.org/2000/svg" 
          xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="251px" height="191px" viewBox="-0.5 -0.5 251 191" content="&lt;mxfile host=&quot;www.draw.io&quot; modified=&quot;2019-12-05T19:55:20.615Z&quot; agent=&quot;Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36&quot; etag=&quot;Jtofw86a3BdbzyPx_j3M&quot; version=&quot;12.3.7&quot; type=&quot;device&quot; pages=&quot;1&quot;&gt;&lt;diagram id=&quot;gSl_QJg_qv7FnLHdkOOz&quot; name=&quot;Page-1&quot;&gt;SOURCE&lt;/diagram&gt;&lt;/mxfile&gt;" style="background-color: rgb(255, 255, 255);">
          <defs/>
          <g>
              <rect x="10" y="10" width="230" height="170" fill="#dae8fc" stroke="#6c8ebf" pointer-events="all"/>
              <g transform="translate(12.5,30.5)">
                  <switch>
                      <foreignObject style="overflow:visible;" pointer-events="all" width="117" height="128" requiredFeatures="http://www.w3.org/TR/SVG11/feature#Extensibility">
                          <div xmlns="http://www.w3.org/1999/xhtml" style="display: inline-block; font-size: 12px; font-family: Helvetica; color: rgb(0, 0, 0); line-height: 1.2; vertical-align: top; width: 118px; white-space: nowrap; overflow-wrap: normal; text-align: left;">
                              <div xmlns="http://www.w3.org/1999/xhtml" style="display:inline-block;text-align:inherit;text-decoration:inherit;white-space:normal;">
                                  <div style="white-space: normal">
                                      <b>
                                          <font style="font-size: 15px">TITLE</font>
                                      </b>
                                  </div>
                                  <div style="white-space: normal">Author: AUTHOR</div>
                                  <div style="white-space: normal">Date: DATE</div>
                                  <div style="white-space: normal">Revision: 1</div>
                                  <div style="white-space: normal">
                                      <br />
                                  </div>
                                  <div style="white-space: normal">
                                      <b>Changelog</b>
                                  </div>
                                  <div style="white-space: normal">
                                      <br />
                                  </div>
                                  <div style="white-space: normal">Rev 1: Initial flowchart</div>
                                  <div>
                                      <br />
                                  </div>
                              </div>
                          </div>
                      </foreignObject>
                      <text x="59" y="70" fill="#000000" text-anchor="middle" font-size="12px" font-family="Helvetica">[Not supported by viewer]</text>
                  </switch>
              </g>
          </g>
      </svg>';
      $source = str_replace("TITLE", rawurlencode($chartname), $source_template);
      $source = str_replace("AUTHOR", rawurlencode($author), $source);
      $source = str_replace("DATE", rawurlencode($date), $source);
      $source = base64_encode(gzdeflate($source));

      $body = str_replace("TITLE", $chartname, $body_template);
      $body = str_replace("AUTHOR", $author, $body);
      $body = str_replace("DATE", $date, $body);
      $body = str_replace("SOURCE", $source, $body);

      $file = PhabricatorFile::newFromFileData($body, $params);
      $content = array(
        'phlowchart' => $file->getDragAndDropDictionary(),
      );
      return id(new AphrontAjaxResponse())->setContent($content);
    }

    $form = id(new AphrontFormView())
      ->appendChild(
        id(new AphrontFormTextControl())
          ->setLabel(pht('Name'))
          ->setName('name')
          ->setValue($request->getStr('name'))
      );

    return $this->newDialog()
      ->setTitle(pht('Phlowchart'))
      ->setErrors($errors)
      ->appendForm($form)
      ->addSubmitButton(pht('Create'))
      ->addCancelButton('/');
  }

}
