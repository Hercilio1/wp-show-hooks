jQuery( function($){
	// show hide the hook flotting window
	$(".wpsh-show-hooks-icon-test").click(function(){
		$(".wpsh-nested-hooks-block").toggleClass("wpsh_show");
		$(".wpsh-nested-hooks-block").addClass("wpsh_transition_fix");
		$(".wpsh-nested-hooks-block").toggleClass("wpsh_slider-fix");
		$(".wpsh-show-hooks-icon-test").toggleClass("wpsh_icon-fix");
	  });

	$(".wpsh-show-move-window").mouseover(function(){
		$("#wpsh-dragable-hook-panel").removeClass("wpsh_transition_fix");
	  });

	$("#disable_callback_function").click(function(){
		$(".wpsh-tab-box-div").toggleClass("wpsh_padding_fix");
	});


    const wrapper = document.querySelector("#wpsh-dragable-hook-panel");
    var header = '';
    if( wrapper !== null ) {
      header = wrapper.querySelector(".wpsh-show-move-window");
    }

    function onDrag({movementX, movementY}){
      let getStyle = window.getComputedStyle(wrapper);
      let leftVal = parseInt(getStyle.left);
      let topVal = parseInt(getStyle.top);
      wrapper.style.left = `${leftVal + movementX}px`;
      wrapper.style.top = `${topVal + movementY}px`;
    }

    if( header ) {
      header.addEventListener("mousedown", ()=>{
        header.classList.add("wpsh_active");
        header.addEventListener("mousemove", onDrag);
      });
  
      document.addEventListener("mouseup", ()=>{
        header.classList.remove("wpsh_active");
        header.removeEventListener("mousemove", onDrag);
      });
    }
});