// THIS FILE IS FOR DEMO PURPOSES ONLY
// AND CAN BE REMOVED AFTER PICKING A STYLE

// Append settings sidebar after page load
document.addEventListener("DOMContentLoaded", function() {
  const html = `<div class="settings">
    <div class="settings-toggle toggle-settings">
      <i class="fas fa-cog"></i>
    </div>

    <div class="settings-panel">
      <div class="settings-title">
        <button type="button" class="close float-right toggle-settings" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>

        <h5>Color schemes</h5>
        <div class="settings-theme toggle-theme" data-theme="blue"></div>
        <div class="settings-theme toggle-theme" data-theme="indigo"></div>
        <div class="settings-theme toggle-theme" data-theme="purple"></div>
        <div class="settings-theme toggle-theme" data-theme="pink"></div>
        <div class="settings-theme toggle-theme" data-theme="red"></div>
        <div class="settings-theme toggle-theme" data-theme="orange"></div>
        <div class="settings-theme toggle-theme" data-theme="yellow"></div>
        <div class="settings-theme toggle-theme" data-theme="green"></div>
        <div class="settings-theme toggle-theme" data-theme="teal"></div>
        <div class="settings-theme toggle-theme" data-theme="cyan"></div>
      </div>
    </div>
  </div>`;

  // Append html to body
  $("body").append(html);

  // Toggle settings
  $(".toggle-settings").on("click", function(e) {
    e.preventDefault();

    $(".settings").toggleClass("open");
  });

  // Toggle theme
  $(".toggle-theme").on("click", function(e) {
    e.preventDefault();

    const theme = $(this).data("theme");

    // Remove all current classNames
    $("body").removeClass();

    // Add theme className
    $("body").addClass(`theme-${theme}`);
  });
});
