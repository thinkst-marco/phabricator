/**
 * @provides javelin-behavior-phlowcharts-base
 * @requires javelin-behavior
 *           javelin-stratcom
 *           javelin-workflow
 *           javelin-dom
 */

JX.behavior('phlowcharts-base', function() {
  var loading = false;
  // alert('loading');
  // JX.Stratcom.listen('click', 'phlowcharts-base', function(e) {
  //   e.kill();
  //   alert('loading');
  //   if (loading) {
  //     return;
  //   }
  //   var link = e.getTarget();

  //   loading = true;
  //   JX.DOM.alterClass(link, 'loading', true);

  //   JX.Workflow.newFromLink(link)
  //     .setHandler(function(r) {
  //       loading = false;
  //       JX.DOM.replace(link, JX.$H(r.markup));
  //     })
  //     .start();
  // });
    var findGetParameter = function(parameterName) {
      var result = null,
      tmp = [];
      var items = location.search.substr(1).split("&");
      for (var index = 0; index < items.length; index++) {
        tmp = items[index].split("=");
        if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
      }
      return result;
    };
    var editor = document.getElementById('drawioeditor');
    // Implements protocol for loading and exporting with embedded XML
    var receive = function(evt)
    {
      if (evt.data.length > 0 && editor)
      {
        var msg = JSON.parse(evt.data);
        if (msg.event == 'configure')
        {
          // Sends the data URI with embedded XML to editor
          editor.contentWindow.postMessage(
            JSON.stringify({action: 'configure', config: {css: "body {font: 13px 'Segoe UI', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Lato', 'Helvetica Neue', Helvetica, Arial, sans-serif !important;} .geMenubarContainer { background-color: #f3f5f7 !important; } .geItem {color: #464C5C !important;} .geMenubar { background-color: #f3f5f7 !important; border-bottom: 2px solid #ddd}"}}), 
            '*');
        }
        // Received if the editor is ready
        else if (msg.event == 'init')
        {
          // Sends the data URI with embedded XML to editor
          editor.contentWindow.postMessage(
            JSON.stringify({action: 'load', xml: editor.getAttribute('data-phlowchart')}), 
            '*');
        }
        // Received if the user clicks save
        else if (msg.event == 'save')
        {
          // Sends a request to export the diagram as XML with embedded PNG
          editor.contentWindow.postMessage(JSON.stringify(
            {action: 'export', format: 'xmlsvg', spinKey: 'saving'}), '*');
        }
        // Received if the export request was processed
        else if (msg.event == 'export')
        {
          // Updates the data URI of the image
          // alert(msg.data);
          document.getElementById('phlowchart-data').value = msg.data;
          document.getElementById('save-phlowchart').submit()
          // editor.setAttribute('data-src-saved', msg.data);
        }
                      
        // Received if the user clicks exit or after export
        if (msg.event == 'exit')
        {
          // Closes the editor
          window.removeEventListener('message', receive);
          var returnTo = findGetParameter('return');
          if (!returnTo) {
            returnTo = '/w/'
          }
          window.location = returnTo;
        }
      }
    };

    // Opens the editor
    window.addEventListener('message', receive);
    editor.setAttribute('src', editor.getAttribute('data-url'));

    // source.drawIoWindow = window.open(url);

});
