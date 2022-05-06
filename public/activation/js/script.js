
const addClick = (el) => {
	el.parent().velocity("slideUp", { duration: 200 })
}

var notification = `
<li class="notification notification-trial">
	<span class="close">X</span>
	<h4>Trial for Device Cloud was successfully requested!</h4>
	<p>Your email request has been successfully sent to your account manager. He will get in contact with you soon.</p>
</li>`

//animate on entering all notification
$("li").velocity("transition.slideDownIn", { stagger: 250 })

//register click event on close button
$(".close").on("click", function(){addClick($(this))})
 
//simulate a new notification after 3 seconds
setTimeout(()=>{
	$("ul")
		.prepend(notification)
		.find(".notification-trial")
		.velocity("slideDown", { duration: 300, queue: false })
		.velocity("transition.slideDownIn")
		.find(".close")
		.on("click", function(){addClick($(this))}
	)
	
	$(".check-all").fadeIn().on("click", function(){
		$(".notification").velocity("slideUp", { duration: 300 })
	})
	
}, 3000);
