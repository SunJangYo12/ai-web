PDFJS.disableWorker = false;

var pdfDoc = null,
  pageNum = 1,
  pageRendering = false,
  pageNumPending = null,
  scale = 2.0,
  canvas = document.getElementById('the-canvas'),
  ctx = canvas.getContext('2d');

  canvas.addEventListener("mousedown", function (e) {
      if (e.clientX < 200) {
          onPrevPage();
      }
      if (e.clientX > 800) {
          onNextPage();
      }
  }, false);


  function renderPage(num) 
  {
      pageRendering = true;
      pdfDoc.getPage(num).then(function(page) 
      {
          var viewport = page.getViewport(scale);
          canvas.height = viewport.height;
          canvas.width = viewport.width;

          var renderContext = {
              canvasContext: ctx,
              viewport: viewport
          };
        
          var renderTask = page.render(renderContext);

          renderTask.promise.then(function () 
          {
              document.title = 'Page: '+pageNum;

              pageRendering = false;
              if (pageNumPending !== null) 
              {
                  renderPage(pageNumPending);
                  pageNumPending = null;
              }
          });
      });

      document.getElementById('page_num').textContent = pageNum;
  }
    
  function queueRenderPage(num) {
      if (pageRendering) {
          pageNumPending = num;
      } 
      else {
          renderPage(num);
      }
  }

  function onPrevPage() {
      document.title = 'Rendering...';
      if (pageNum <= 1) {
          return;
      }
      pageNum--;
      queueRenderPage(pageNum);
  }

  function onNextPage() {
      document.title = 'Rendering...';
      if (pageNum >= pdfDoc.numPages) {
          return;
      }
      pageNum++;
      queueRenderPage(pageNum);
  }

  function onGotoPage() {
      var pageNo = document.getElementById("edtgo").value;
      if (pageNo < 1 || pageNo > pdfDoc.numPages) {
          return;
      }
      pageNum = pageNo;
      queueRenderPage(pageNum);
  }

  
    
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
      callGetDocment(e.currentTarget.response);
      document.title = 'Rendering...';
  };
  xhr.onerror = function  () {
      alert("The pdf may not be downloded or it may be xhr error.Please be patient as we are working on this issue.");
  }
  xhr.send();
