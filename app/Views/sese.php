<!DOCTYPE html>
<html>
<head>
  <title>SSE Counter</title>
</head>
<body>
  <h2>Live Counter:</h2>
  <div id="counter" style="font-size: 40px;">0</div>

  <script>
    const eventSource = new EventSource("/sese/counter");

    eventSource.onmessage = function(event) {
      const data = JSON.parse(event.data);
      document.getElementById("counter").textContent = data.counter;
    };

    eventSource.addEventListener("end", function() {
      console.log("SSE stream finished");
      eventSource.close();
    });
  </script>
</body>
</html>
