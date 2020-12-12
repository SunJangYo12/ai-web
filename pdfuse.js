  // NOTE: 
    // Modifying the URL below to another server will likely *NOT* work. Because of browser
    // security restrictions, we have to use a file server with special headers
    // (CORS) - most servers don't support cross-origin browser requests.
    //

    //
    // Disable workers to avoid yet another cross-origin issue (workers need the URL of
    // the script to be loaded, and currently do not allow cross-origin scripts)
    //
    PDFJS.disableWorker = false;

    var pdfDoc = null,
        pageNum = 1,
        pageRendering = false,
        pageNumPending = null,
        scale = 2.5,
        canvas = document.getElementById('the-canvas'),
        ctx = canvas.getContext('2d');
    
    /**
     * Get page info from document, resize canvas accordingly, and render page.
     * @param num Page number.
     */
    function renderPage(num) {
      pageRendering = true;
      // Using promise to fetch the page
      pdfDoc.getPage(num).then(function(page) {
        
     

        var viewport = page.getViewport(scale);
        canvas.height = viewport.height;
        canvas.width = viewport.width;

        // Render PDF page into canvas context
        var renderContext = {
          canvasContext: ctx,
          viewport: viewport
        };
        var renderTask = page.render(renderContext);
        
        // Wait for rendering to finish
        renderTask.promise.then(function () {
          pageRendering = false;
          if (pageNumPending !== null) {
            // New page rendering is pending
            renderPage(pageNumPending);
            pageNumPending = null;
          }
        });
      });

      // Update page counters
      document.getElementById('page_num').textContent = pageNum;
    }
    
    /**
     * If another page rendering in progress, waits until the rendering is
     * finished. Otherwise, executes rendering immediately.
     */
    function queueRenderPage(num) {
      if (pageRendering) {
        pageNumPending = num;
      } else {
        renderPage(num);
      }
    }

    function tes() {
      alert(1);
    }

    /**
     * Displays previous page.
     */
    function onPrevPage() {
      if (pageNum <= 1) {
        return;
      }
      pageNum--;
      queueRenderPage(pageNum);
    }

    
/**
    
 * Go to particular page.
    
*/
 
  function onGotoPage() {
    var pageNo = document.getElementById("edtgo").value;
    if (pageNo < 1 || pageNo > pdfDoc.numPages) {
      return;
    }
    pageNum = pageNo;
    queueRenderPage(pageNum);
  }

/**
     * Displays next page.
     */
    function onNextPage() {
      if (pageNum >= pdfDoc.numPages) {
        return;
      }
      pageNum++;
      queueRenderPage(pageNum);
    }
    

    /**
     * Asynchronously downloads PDF.
     */
  function callGetDocment (response) {  
  
   PDFJS.getDocument(response).then(function getPdfHelloWorld(_pdfDoc) {
   pdfDoc = _pdfDoc;
   document.getElementById('page_count').textContent = pdfDoc.numPages;
   renderPage(pageNum);
});
}

    var xhr = new XMLHttpRequest();
              xhr.open('GET', url, true);
              xhr.responseType = 'arraybuffer';
              xhr.onload = function(e) {

                //binary form of ajax response,
                callGetDocment(e.currentTarget.response);
              };
              xhr.onerror = function  () {
                // body...
                alert("The pdf may not be downloded or it may be xhr error.Please be patient as we are working on this issue.");
              }
              xhr.send();
