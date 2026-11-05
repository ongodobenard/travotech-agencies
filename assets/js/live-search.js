(function(){
  var MIN=2;
  function debounce(fn,ms){var t;return function(){var a=arguments,c=this;clearTimeout(t);t=setTimeout(function(){fn.apply(c,a);},ms);};}

  /* styles for the dropdown */
  var st=document.createElement('style');
  st.textContent='.th-search{position:relative}.ls-box{position:absolute;left:0;right:0;top:100%;margin-top:6px;background:#fff;border:1.5px solid #d7f0f0;border-radius:10px;box-shadow:0 14px 36px rgba(9,60,60,.22);z-index:99999;overflow:hidden;display:none;font-family:var(--th-fb,Inter,sans-serif);color:#183332}'
   +'.ls-box.on{display:block}.ls-list{max-height:min(420px,60vh);overflow-y:auto}'
   +'.ls-item{display:flex;align-items:center;gap:12px;padding:9px 12px;border-bottom:1px solid #edf8f8;text-decoration:none;color:inherit}.ls-item:hover,.ls-item.hl{background:#e4fafa}'
   +'.ls-item img,.ls-ph{width:44px;height:44px;object-fit:contain;background:#f1fafa;border-radius:6px;flex-shrink:0}'
   +'.ls-name{flex:1;min-width:0;font-size:.85rem;font-weight:600;line-height:1.3;color:#093c3c}'
   +'.ls-price{font-weight:800;font-size:.82rem;color:#22adb0;white-space:nowrap}'
   +'.ls-msg{padding:16px;font-size:.85rem;color:#6b7280;text-align:center}'
   +'.ls-all{display:block;padding:11px 12px;text-align:center;font:600 13px var(--th-fh,Oswald,sans-serif);letter-spacing:.04em;text-transform:uppercase;background:#093c3c;color:#fff;text-decoration:none}'
   +'.ls-busy{opacity:.45;transition:opacity .15s}';
  document.head.appendChild(st);

  /* WooCommerce Store API url (works with pretty and plain permalinks) */
  var link=document.querySelector('link[rel="https://api.w.org/"]');
  var api=(link&&link.href)||'/wp-json/';
  if(api.slice(-1)!=='/')api+='/';
  var apiUrl=api+'wc/store/v1/products';
  function apiQ(term){return apiUrl+(apiUrl.indexOf('?')>-1?'&':'?')+'per_page=7&search='+encodeURIComponent(term);}
  function money(p){
    var pr=p.prices||{},m=pr.currency_minor_unit!=null?pr.currency_minor_unit:2,n=parseInt(pr.price,10);
    if(isNaN(n))return '';
    return 'KES '+(n/Math.pow(10,m)).toLocaleString(undefined,{minimumFractionDigits:2,maximumFractionDigits:2});
  }

  /* ---------- 1) Dropdown for header (and any non-shop) search fields ---------- */
  function dropdown(form){
    var input=form.querySelector('input[type="search"],input[name="s"]');
    if(!input||form.getAttribute('data-ls'))return;
    form.setAttribute('data-ls','1');
    input.setAttribute('autocomplete','off');
    var host=form.parentNode;
    if(getComputedStyle(host).position==='static')host.style.position='relative';
    var box=document.createElement('div');box.className='ls-box';box.setAttribute('role','listbox');
    host.appendChild(box);
    var seq=0,items=[],idx=-1;
    function close(){box.classList.remove('on');idx=-1;}
    function msg(t){box.innerHTML='';var d=document.createElement('div');d.className='ls-msg';d.textContent=t;box.appendChild(d);box.classList.add('on');}
    function render(list,term){
      box.innerHTML='';
      if(!list.length){msg('No products found for "'+term+'"');return;}
      var wrap=document.createElement('div');wrap.className='ls-list';
      list.forEach(function(p){
        var a=document.createElement('a');a.className='ls-item';a.href=p.permalink;
        var im=p.images&&p.images[0]?(p.images[0].thumbnail||p.images[0].src):'';
        if(im){var i=document.createElement('img');i.src=im;i.alt='';i.loading='lazy';a.appendChild(i);}else{var s=document.createElement('span');s.className='ls-ph';a.appendChild(s);}
        var n=document.createElement('span');n.className='ls-name';n.textContent=(p.name||'').replace(/&amp;/g,'&').replace(/&#8217;/g,"'");a.appendChild(n);
        var pr=document.createElement('span');pr.className='ls-price';pr.textContent=money(p);a.appendChild(pr);
        wrap.appendChild(a);
      });
      box.appendChild(wrap);
      var all=document.createElement('a');all.className='ls-all';
      all.href=form.action+(form.action.indexOf('?')>-1?'&':'?')+'s='+encodeURIComponent(term)+'&post_type=product';
      all.textContent='See all results';box.appendChild(all);
      items=[].slice.call(box.querySelectorAll('.ls-item'));idx=-1;
      box.classList.add('on');
    }
    var run=debounce(function(){
      var term=input.value.trim();
      if(term.length<MIN){close();return;}
      var my=++seq;
      fetch(apiQ(term)).then(function(r){return r.json();}).then(function(d){
        if(my!==seq)return;
        render(Array.isArray(d)?d:[],term);
      }).catch(function(){if(my===seq)close();});
    },250);
    input.addEventListener('input',run);
    input.addEventListener('focus',function(){if(box.children.length&&input.value.trim().length>=MIN)box.classList.add('on');});
    input.addEventListener('keydown',function(e){
      if(e.key==='Escape'){close();return;}
      if(!box.classList.contains('on')||!items.length)return;
      if(e.key==='ArrowDown'||e.key==='ArrowUp'){
        e.preventDefault();
        if(items[idx])items[idx].classList.remove('hl');
        idx=e.key==='ArrowDown'?(idx+1)%items.length:(idx<=0?items.length-1:idx-1);
        items[idx].classList.add('hl');items[idx].scrollIntoView({block:'nearest'});
      }else if(e.key==='Enter'&&idx>-1){e.preventDefault();window.location.href=items[idx].href;}
    });
    document.addEventListener('click',function(e){if(!host.contains(e.target))close();});
  }

  /* ---------- 2) Shop page: filter the product grid while typing ---------- */
  function shopLive(form){
    var input=form.querySelector('input[type="search"]');
    var grid=document.getElementById('shProducts');
    if(!input||!grid)return;
    input.setAttribute('autocomplete','off');
    var seq=0;
    function bindAtc(){
      grid.querySelectorAll('.sh-atc:not([data-ls])').forEach(function(btn){
        btn.setAttribute('data-ls','1');
        btn.addEventListener('click',function(e){
          e.preventDefault();
          try{sessionStorage.setItem('cv_scroll_pos',String(window.pageYOffset||0));}catch(x){}
          btn.classList.add('atc-loading');
          var t=btn.querySelector('.t');if(t)t.textContent='Adding...';
          var u=new URL(window.location.href);
          u.searchParams.set('add-to-cart',btn.getAttribute('data-pid'));
          u.searchParams.set('quantity','1');
          u.searchParams.set('cv_added_name',btn.getAttribute('data-name'));
          window.location.href=u.toString();
        });
      });
    }
    var run=debounce(function(){
      var term=input.value.trim();
      var u;
      if(term===''){
        var a=document.querySelector('.sh-cats li a');
        u=new URL(a?a.href:window.location.pathname,window.location.origin);
      }else{
        u=new URL(form.action,window.location.origin);
        u.searchParams.set('s',term);u.searchParams.set('post_type','product');
      }
      var my=++seq;
      grid.classList.add('ls-busy');
      fetch(u.toString(),{credentials:'same-origin'}).then(function(r){return r.text();}).then(function(html){
        if(my!==seq)return;
        var doc=new DOMParser().parseFromString(html,'text/html');
        var ng=doc.getElementById('shProducts');
        if(!ng)throw new Error('no grid');
        grid.innerHTML=ng.innerHTML;
        var oc=document.querySelector('.sh-count'),nc=doc.querySelector('.sh-count');
        if(oc&&nc)oc.textContent=nc.textContent;
        var oh=document.getElementById('sh-h1'),nh=doc.getElementById('sh-h1');
        if(oh&&nh)oh.textContent=nh.textContent;
        var op=document.querySelector('.sh-pg'),np=doc.querySelector('.sh-pg');
        if(op)op.remove();
        if(np){grid.parentNode.appendChild(document.importNode(np,true));}
        grid.classList.remove('ls-busy');
        bindAtc();
        try{history.replaceState(null,'',term===''?u.pathname:u.search);}catch(e){}
      }).catch(function(){if(my===seq)grid.classList.remove('ls-busy');});
    },350);
    input.addEventListener('input',run);
    form.addEventListener('submit',function(e){e.preventDefault();run();});
  }

  function init(){
    document.querySelectorAll('form.sh-search').forEach(shopLive);
    document.querySelectorAll('form[role="search"],.th-search form,form.search-form,.widget_search form').forEach(function(f){
      if(f.classList.contains('sh-search')&&document.getElementById('shProducts'))return;
      dropdown(f);
    });
  }
  if(document.readyState==='loading')document.addEventListener('DOMContentLoaded',init);else init();
})();