window.onload = function() {
    var search = document.getElementById('s');

    search.changed = false;
    search.defaultValue = search.value;

    search.onfocus = function() { if (!this.changed) { this.className = 'active'; this.value = ''; } };
    search.onblur = function() { if (!this.changed || this.value == '') { this.className = ''; this.value = this.defaultValue; this.changed = false; } };
    search.onkeyup = function() { this.changed = true; }; 
}
