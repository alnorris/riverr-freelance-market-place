window.toast=function(e,s="success"){switch(toastr.options={closeButton:!1,debug:!1,newestOnTop:!1,progressBar:!1,positionClass:"toast-top-right",preventDuplicates:!1,onclick:null,showDuration:"10000",hideDuration:"500",timeOut:"5000",extendedTimeOut:"1000",showEasing:"swing",hideEasing:"linear",showMethod:"fadeIn",hideMethod:"fadeOut"},s){case"success":toastr.success(e);break;case"error":toastr.error(e);break;case"info":toastr.info(e);break;case"warning":toastr.warning(e)}},window.rating=function(e){var s=document.getElementsByClassName(e.target);for(let t=0;t<s.length;t++){const o=s[t];$(o).rateYo({rating:o.getAttribute("data-rating-value"),starWidth:void 0===e.size?"15px":e.size,ratedFill:e.fill,normalFill:e.background,halfStar:!0,readOnly:!0,starSvg:'<svg class="flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"> <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path> </svg>'})}},window.splidejs=function(e="splide"){for(var s=document.getElementsByClassName(e),t=0,o=s.length;t<o;t++)new Splide(s[t],{type:"loop",cover:!0,autoplay:!1,pauseOnHover:!0,heightRatio:.3,height:200,rewind:!0,pagination:!1,arrows:!0,video:{loop:!0,mute:!0}}).mount(window.splide.Extensions)},window.slickjs=function(e="slick-element",s=null){s?$(e).slick(s):$(e).slick({dots:!0,infinite:!1,speed:300,slidesToShow:4,slidesToScroll:1,responsive:[{breakpoint:1024,settings:{slidesToShow:3,slidesToScroll:3,infinite:!0,dots:!0}},{breakpoint:600,settings:{slidesToShow:2,slidesToScroll:2}},{breakpoint:480,settings:{slidesToShow:1,slidesToScroll:1}}]})};