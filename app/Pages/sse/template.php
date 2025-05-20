<div
    id="sse"
    x-data="$heroic({
        title: `<?= $page_title ?>`,
        url: `sse/data`
        })">

    <div class="text-center py-3">
        <h1>Welcome <span x-text="data.name"></span>!</h1>

        <div id="counter" style="font-size: 40px;">0</div>
    </div>

</div>

<script>
    const eventSource = new EventSource("/sse/counter");

    eventSource.onmessage = function(event) {
      const data = JSON.parse(event.data);
      document.getElementById("counter").textContent = data.counter;
    };

    eventSource.addEventListener("end", function() {
      console.log("SSE stream finished");
      eventSource.close();
    });
  </script>