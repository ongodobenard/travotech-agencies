<style>
#travotech-toast{position:fixed;bottom:100px;right:24px;z-index:999999;width:min(340px,calc(100vw - 24px));background:var(--th-dk,#093c3c);color:#fff;border-radius:12px;padding:14px 16px 18px;box-shadow:0 12px 40px rgba(0,0,0,.3);display:flex;align-items:flex-start;gap:12px;opacity:0;transform:translateY(20px);transition:opacity .3s,transform .3s;pointer-events:none;overflow:hidden;font-family:var(--th-fb,'Inter',sans-serif);}
#travotech-toast.cv-show{opacity:1;transform:translateY(0);pointer-events:auto;}
#travotech-toast .cv-ic{width:36px;height:36px;border-radius:50%;background:var(--th-g,#22adb0);display:flex;align-items:center;justify-content:center;flex-shrink:0;}
#travotech-toast .cv-body{flex:1;min-width:0;}
#travotech-toast .cv-title{font-size:.72rem;font-weight:800;text-transform:uppercase;letter-spacing:.08em;color:#22adb0;margin-bottom:3px;}
#travotech-toast .cv-name{font-size:.88rem;font-weight:700;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;margin-bottom:10px;}
#travotech-toast .cv-act{display:flex;gap:8px;}
#travotech-toast .cv-act a,#travotech-toast .cv-act button{display:inline-flex;align-items:center;gap:6px;padding:7px 12px;border-radius:6px;font:700 12px var(--th-fb,'Inter',sans-serif);border:0;cursor:pointer;text-decoration:none;}
#travotech-toast .cv-act a{background:var(--th-red,#e53935);color:#fff;}
#travotech-toast .cv-act button{background:rgba(255,255,255,.12);color:#fff;}
#travotech-toast .cv-bar{position:absolute;left:0;right:0;bottom:0;height:4px;background:var(--th-g,#22adb0);transform-origin:left;}
#travotech-toast.cv-show .cv-bar{animation:cvCount 5s linear forwards;}
@keyframes cvCount{from{transform:scaleX(1);}to{transform:scaleX(0);}}
.cv-loading{opacity:.65 !important;pointer-events:none !important;}
@media (max-width:560px){#travotech-toast{right:12px;left:12px;width:auto;bottom:84px;}}
</style>
<div id="travotech-toast" role="alert" aria-live="assertive">
  <div class="cv-ic"><i class="fa-solid fa-check" aria-hidden="true"></i></div>
  <div class="cv-body">
    <div class="cv-title">Added to cart</div>
    <div class="cv-name" id="cv-toast-name"></div>
    <div class="cv-act">
      <a href="<?php echo esc_url( wc_get_cart_url() ); ?>"><i class="fa-solid fa-bag-shopping" aria-hidden="true"></i> View cart</a>
      <button type="button" id="cv-toast-close">Dismiss</button>
    </div>
  </div>
  <div class="cv-bar" id="cv-toast-bar"></div>
</div>
<script>
(function(){
  var $=function(id){return document.getElementById(id);};
  var toast=$('travotech-toast'),tn=$('cv-toast-name'),bar=$('cv-toast-bar'),tc=$('cv-toast-close'),timer=null;
  function showToast(name){
    if(!toast)return;
    if(tn)tn.textContent=name||'';
    if(bar){bar.style.animation='none';void bar.offsetWidth;bar.style.animation='';}
    toast.classList.add('cv-show');
    if(timer)clearTimeout(timer);
    timer=setTimeout(function(){toast.classList.remove('cv-show');},5000);
  }
  if(tc)tc.addEventListener('click',function(){toast.classList.remove('cv-show');if(timer)clearTimeout(timer);});

  /* after the reload: restore scroll, show toast, clean the URL */
  var params=new URLSearchParams(window.location.search);
  var added=params.get('cv_added_name');
  var saved=null;try{saved=sessionStorage.getItem('cv_scroll_pos');}catch(e){}
  if(added){
    if(saved!==null){window.scrollTo(0,parseInt(saved,10));}
    window.addEventListener('load',function(){if(saved!==null){window.scrollTo(0,parseInt(saved,10));}try{sessionStorage.removeItem('cv_scroll_pos');}catch(e){}});
    document.addEventListener('DOMContentLoaded',function(){showToast(added);});
    var cu=new URL(window.location.href);
    ['cv_added_name','added-to-cart','add-to-cart','quantity'].forEach(function(k){cu.searchParams.delete(k);});
    window.history.replaceState(null,'',cu.toString());
  }

  /* take over every add-to-cart button on this page (capture phase beats other scripts) */
  var SEL='a[href*="add-to-cart="],button[data-product_id],a[data-product_id],.add_to_cart_button,.ajax_add_to_cart,[data-pid],.hp-atc';
  document.addEventListener('click',function(e){
    var el=e.target.closest?e.target.closest(SEL):null;
    if(!el||el.closest('#travotech-toast'))return;
    var pid=el.getAttribute('data-pid')||el.getAttribute('data-product_id')||el.getAttribute('data-product-id');
    if(!pid){var m=(el.getAttribute('href')||'').match(/add-to-cart=(\d+)/);if(m)pid=m[1];}
    if(!pid)return;
    e.preventDefault();e.stopImmediatePropagation();
    var name=el.getAttribute('data-name');
    if(!name){
      var card=el.closest('article,li,[class*="card"],[class*="item"]');
      var t=card?card.querySelector('h2,h3,h4,[class*="name"],[class*="title"]'):null;
      name=t?t.textContent.trim():'Product';
    }
    if(name.length>30)name=name.slice(0,30)+'...';
    try{sessionStorage.setItem('cv_scroll_pos',String(window.pageYOffset||document.documentElement.scrollTop||0));}catch(x){}
    el.classList.add('cv-loading');
    var tx=el.querySelector('.t');if(tx)tx.textContent='Adding...';
    var u=new URL(window.location.href);
    u.searchParams.set('add-to-cart',pid);
    u.searchParams.set('quantity','1');
    u.searchParams.set('cv_added_name',name);
    window.location.href=u.toString();
  },true);
})();
</script>