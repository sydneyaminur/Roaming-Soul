// Interactive enhancements for Roaming Soul
(function() {
  'use strict';

  const doc = document;

  /* ===== Scroll Reveal ===== */
  const revealEls = [].slice.call(doc.querySelectorAll('.reveal'));
  if ('IntersectionObserver' in window && revealEls.length) {
    const io = new IntersectionObserver(entries => {
      entries.forEach(e => {
        if (e.isIntersecting) {
          e.target.classList.add('visible');
          io.unobserve(e.target);
        }
      });
    }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });
    revealEls.forEach(el => io.observe(el));
  } else {
    // Fallback: show all
    revealEls.forEach(el => el.classList.add('visible'));
  }

  /* ===== Back To Top Button ===== */
  const backBtn = doc.getElementById('backToTop');
  if (backBtn) {
    const toggleBackBtn = () => {
      if (window.scrollY > 500) backBtn.classList.add('show'); else backBtn.classList.remove('show');
    };
    window.addEventListener('scroll', toggleBackBtn, { passive: true });
    toggleBackBtn();
    backBtn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
  }

  /* ===== Active Nav Link on Scroll ===== */
  const navLinks = [].slice.call(doc.querySelectorAll('.nav-link[href^="#"]'));
  const sections = navLinks.map(l => doc.querySelector(l.getAttribute('href'))).filter(Boolean);
  if ('IntersectionObserver' in window && sections.length) {
    const highlight = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const id = '#' + entry.target.id;
            navLinks.forEach(l => l.classList.toggle('active', l.getAttribute('href') === id));
        }
      });
    }, { threshold: 0.5 });
    sections.forEach(s => highlight.observe(s));
  }

  /* ===== Modal (Login) ===== */
  const modalTriggers = doc.querySelectorAll('[data-open-modal]');
  modalTriggers.forEach(trigger => {
    trigger.addEventListener('click', e => {
      e.preventDefault();
      const targetId = trigger.getAttribute('data-open-modal');
      openModal(targetId);
    });
  });

  function openModal(id) {
    const modal = doc.getElementById(id);
    if (!modal) return;
    modal.classList.add('open');
    modal.setAttribute('aria-hidden', 'false');
    modal.setAttribute('aria-modal', 'true');
    // Focus first input
    const firstInput = modal.querySelector('input, button, [tabindex]:not([tabindex="-1"])');
    if (firstInput) setTimeout(() => firstInput.focus(), 120);
    doc.body.style.overflow = 'hidden';
  }

  function closeModal(modal) {
    modal.classList.remove('open');
    modal.setAttribute('aria-hidden', 'true');
    modal.setAttribute('aria-modal', 'false');
    doc.body.style.overflow = '';
  }

  doc.addEventListener('click', e => {
    const closeAttr = e.target.closest('[data-close-modal]');
    if (closeAttr) {
      const modal = e.target.closest('.modal');
      if (modal) closeModal(modal);
    }
  });

  doc.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
      const openModalEl = doc.querySelector('.modal.open');
      if (openModalEl) closeModal(openModalEl);
    }
  });

  // Close if click outside dialog area
  doc.addEventListener('mousedown', e => {
    const modal = e.target.closest('.modal');
    if (!modal) return;
    const dialog = e.target.closest('.modal-dialog');
    if (!dialog && modal.classList.contains('open')) closeModal(modal);
  });

  /* ===== Lottie Loader Hide Logic ===== */
  const lottieLoader = doc.getElementById('appLoader');
  if (lottieLoader) {
    window.addEventListener('load', () => {
      setTimeout(()=> { lottieLoader.classList.add('hide'); }, 400); // small delay for polish
      setTimeout(()=> { lottieLoader.remove(); }, 1400);
    });
    // Fallback auto-hide after 7s if load event delayed
    setTimeout(()=> { if(lottieLoader && !lottieLoader.classList.contains('hide')) { lottieLoader.classList.add('hide'); setTimeout(()=> lottieLoader.remove(), 1000); } }, 7000);
  }

  /* ===== Navbar style change on About section ===== */
  const navbar = doc.querySelector('.navbar');
  const aboutSection = doc.getElementById('about');
  if (navbar && aboutSection) {
    const threshold = () => aboutSection.offsetTop - 20; // trigger close to section start
    const onScrollNav = () => {
      if (window.scrollY >= threshold()) navbar.classList.add('white'); else navbar.classList.remove('white');
    };
    window.addEventListener('scroll', onScrollNav, { passive: true });
    window.addEventListener('resize', onScrollNav);
    onScrollNav();
  }

  /* ===== Monkey Show/Hide Password ===== */
  const pwInput = doc.getElementById('loginPassword');
  const monkeyBtn = pwInput ? pwInput.parentElement.querySelector('.monkey-toggle') : null;
  if (pwInput && monkeyBtn) {
    monkeyBtn.addEventListener('click', () => {
      const show = pwInput.type === 'password';
      pwInput.type = show ? 'text' : 'password';
      monkeyBtn.setAttribute('aria-pressed', String(show));
      monkeyBtn.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
      if(monkeyBtn.classList.contains('emoji')) {
        monkeyBtn.textContent = show ? '🙈' : '🐵';
      } else {
        monkeyBtn.classList.remove('jiggle'); void monkeyBtn.offsetWidth; monkeyBtn.classList.add('jiggle');
      }
    });
  }

  /* ===== Tour Page Dynamic Content (migrated from per-page inline scripts) ===== */
  if (document.body.classList.contains('tour-page')) {
    const tourKey = document.body.getAttribute('data-tour');
    const metaConfig = {
      sundarbans: { duration:'5 Days', focus:'Wildlife / Ecology', date:'15th January 2026', baseRegistered:17, capacity:80, itinerary:[
        ['Khulna Boarding','Night launch boarding, briefing & orientation.'],
        ['Canal Cruise','Early canal ride, mangrove interpretation, village interaction.'],
        ['Tiger Watch Zones','Watch towers, track interpretation, eco education session.'],
        ['Bird & Dolphin Sight','Creek exploration, dolphin spotting stretch, community crafts.'],
        ['Return & Debrief','Morning short cruise, return to Khulna, bus back.']
      ]},
      bandarban: { duration:'4 Days', focus:'Mountains / Culture', date:null, baseRegistered:5, capacity:80, itinerary:[
        ['Arrival & Viewpoint','Milanchari viewpoint and local dinner.'],
        ['Trail & Villages','Guided trek, indigenous village visit, cultural interaction.'],
        ['Sunrise & Waterfall','Early sunrise hill, waterfall exploration, rest afternoon.'],
        ['Local Market & Return','Morning market walk and departure.']
      ]},
      sylhet: { duration:'3 Days', focus:'Tea Culture / Nature', date:'15th January 2026', baseRegistered:9, capacity:80, itinerary:[
        ['Walk Through Lush Tea Plantations','Enjoy misty mornings among emerald rows and capture stunning photos.'],
        ['Watch Tea Leaf Plucking','Observe skilled workers hand-pick tender leaves using traditional methods.'],
        ['Visit a Tea Processing Factory','Learn how fresh leaves become fragrant tea and sample a just-brewed cup.'],
        ['Explore Jaflong & Khasi Hills','River scenery, stone beds & glimpses of Khasi culture.'],
        ['Sunrise Over the Tea Gardens','Golden dawn over rolling green slopes.'],
        ['Stay in a Tea Garden Homestay','Fresh pours, local hospitality, evening serenity.']
      ]},
      rangamati: { duration:'3 Days', focus:'Lake / Culture', date:'10th March 2026', baseRegistered:8, capacity:80, itinerary:[
        ['Boat Ride on Rangamati Lake','Glide over serene blue-green waters encircled by forested hills.'],
        ['Visit Kaptai Dam','Observe the hydroelectric dam and scenic surroundings.'],
        ['Explore Tribal Villages','Chakma, Marma & Tripura culture, crafts, textiles.'],
        ['Sunset Over The Lake','Breathtaking color gradients on calm evening water.'],
        ['Hanging Bridge Experience','Iconic span ideal for photos & wide hill views.'],
        ['Local Lakeside Cuisine','Fresh fish dishes & traditional hill tribal flavors.']
      ]},
      'saint-martins': { duration:'4 Days', focus:'Island / Marine', date:'16th November 2025', baseRegistered:12, capacity:80, itinerary:[
        ['Relax on the Main Beach','Soak up the sun on the island’s beautiful white sandy shore.'],
        ['Snorkeling & Diving','Explore vibrant coral reefs teeming with marine life.'],
        ['Coral Fish Aquarium','Exhibits highlighting rich marine biodiversity.'],
        ['“Jellyfish Lake” (Sailor’s Lake)','Inland lake with non‑stinging jellyfish.'],
        ['Fresh Seafood Tasting','Local catches at beachside stalls & rustic eateries.'],
        ['Coral Stone Formations','Exposed coral pools & formations during low tide.'],
        ['Sunset Over Bay of Bengal','Spectacular horizon color gradients.'],
        ['Scenic Boat Circuit','Boat trip for panoramic views & photos.']
      ]},
      'coxs-bazar': { duration:'4 Days / 3 Nights', focus:'Beach / Culture', date:'15th December 2025', baseRegistered:20, capacity:70, itinerary:[
        ['Arrival & Sunset','After a long day of travel, we will relax at the hotel for the night.'],
        ['Beach & Himchari','Sunrise walk, chill time, Himchari National Park & waterfall, evening bazaar.'],
        ['Inani & Activities','Inani Beach, rock pools, optional surfing / ATV / cleanup.'],
        ['Free Morning & Return','Optional sunrise, souvenirs and return after lunch.'],
        ['Visit Himchari National Park','Hills, waterfalls and sweeping sea views.'],
        ['Enjoy Inani Beach','Clean blue water and coral stones.'],
        ['Go to Saint Martin’s Island','Optional side trip to coral paradise (logistics dependent).'],
        ['Experience Laboni Beach','Perfect for sunset watching.'],
        ['Explore Moheshkhali Island','Hills, mangroves & Adinath Temple.'],
        ['Boat Ride on Bakkhali River','Peaceful scenic cruise.'],
        ['Shop at Burmese Market','Handicrafts, clothes & souvenirs.'],
        ['Taste Fresh Seafood','Lobster, crab and prawns.'],
        ['Try Beach Sports','Football, volleyball or horse riding.'],
        ['Parasailing / Jet Skiing','Adventure thrill add‑ons.'],
        ['Visit Radiant Fish World','First fish aquarium & amusement center.'],
        ['Sunrise from Kolatoli Beach','Early morning beauty.'],
        ['Trek to Ramu Buddhist Temples','Cultural heritage & history.']
      ]}
    };
    const cfg = metaConfig[tourKey];
    if (cfg) {
      // Meta chips
      const metaEl = doc.getElementById('tourMeta');
      if (metaEl) {
        const items = [ ['DURATION', cfg.duration], ['FOCUS', cfg.focus] ];
        if (cfg.date) items.push(['VISITING DATE', cfg.date]);
        items.forEach((m,i)=>{ const chip=doc.createElement('div'); chip.className='chip'+(i===0?' primary':''); chip.innerHTML=`<span>${m[0]}</span> ${m[1]}`; metaEl.appendChild(chip); });
      }
      // Itinerary list
      const list = doc.getElementById('planList');
      if (list && cfg.itinerary) {
        cfg.itinerary.forEach(it => { const li=doc.createElement('li'); li.className='reveal'; li.innerHTML=`<h3>${it[0]}</h3><p>${it[1]}</p>`; list.appendChild(li); });
        requestAnimationFrame(()=> doc.querySelectorAll('.reveal').forEach(el=>el.classList.add('visible')));
      }
      // Registration counters
      let registered = cfg.baseRegistered;
      try { const extra = JSON.parse(localStorage.getItem('tourExtraRegistrations')||'{}'); if (extra[tourKey]) registered += extra[tourKey]; } catch(e){}
      const target = cfg.capacity;
      const regCount = doc.getElementById('regCount');
      const regAvail = doc.getElementById('regAvailable');
      const regProgress = doc.getElementById('regProgress');
      const regMessage = doc.getElementById('regMessage');
      const regTargetEl = doc.getElementById('regTarget');
      function updateReg(){
        if(!regCount) return; regCount.textContent = registered; const remaining = Math.max(0,target-registered); if(regAvail) regAvail.textContent = remaining; if(regTargetEl) regTargetEl.textContent = target; const pct = Math.min(100, Math.round((registered/target)*100)); if(regProgress) regProgress.style.width = pct+'%'; if(regMessage) regMessage.textContent = pct>=100? 'Registration full – waitlist only.' : `${pct}% of spots filled. ${remaining} spots left.`; }
      updateReg();
      const regBtn = doc.getElementById('registerBtn');
      if (regBtn) regBtn.addEventListener('click', ()=> { location.href = `registration.html?tour=${tourKey}`; });
    }
  }

  /* ===== Registration Page Logic (centralized) ===== */
  if (document.body.classList.contains('registration-page')) {
    const params=new URLSearchParams(location.search); const tour=params.get('tour');
    const heading=document.getElementById('joinHeading');
    const lead=document.getElementById('joinLead');
    const appLoader=document.getElementById('appLoader');
    if(appLoader){
      window.addEventListener('load', ()=> setTimeout(()=> appLoader.classList.add('hide'),450));
      setTimeout(()=> appLoader.classList.add('hide'),7000);
    }
    function showLoaderAndNavigate(url, delay=450){ if(appLoader){ appLoader.setAttribute('aria-label','Loading next page'); appLoader.classList.remove('hide'); } setTimeout(()=>{ location.href=url; }, delay); }
    function formatTitle(k){ return k.replace(/-/g,' ').replace(/\b\w/g,ch=>ch.toUpperCase()); }
    if(tour){
      heading.textContent='Join '+ formatTitle(tour) + ' Tour';
      lead.textContent='Tell us how many people are joining the '+ formatTitle(tour) +' adventure.';
      const backLink=document.getElementById('backLink');
      if(backLink){
        if(tour==='sundarbans') backLink.href='shundarban.html';
        else if(tour==='bandarban') backLink.href='bandarban.html';
        else if(tour==='sylhet' || tour==='sylhet-tea') backLink.href='sylhet.html';
        else if(tour==='rangamati') backLink.href='rangamati.html';
        else if(tour==='saint-martins') backLink.href='sentmartin.html';
        else backLink.href='coxs-bazar.html';
      }
    }
    const form=document.getElementById('joinForm'); if(form){
      const success=document.getElementById('successMsg');
      const liveErrors=document.getElementById('liveErrors');
      const fields={
        name:{el:document.getElementById('name'),rule(v){return v.trim().length>=3||'Name must be at least 3 characters';}},
        email:{el:document.getElementById('email'),rule(v){return (/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/).test(v.trim())||'Enter a valid email address';}},
        phone:{el:document.getElementById('phone'),rule(v){return (/^\d{11}$/).test(v.trim())||'Phone must be exactly 11 digits';}},
        party:{el:document.getElementById('party'),rule(v){if(v==='') return true; const n=Number(v); return (n>=0 && n<1001)||'Value must be 0 - 1000';}},
        gender:{el:document.getElementById('gender'),rule(v){return v.trim()!==''||'Select a gender';}}
      };
      function showError(key,msg){ const wrapper=document.getElementById('field-'+key); if(!wrapper) return; const box=wrapper.querySelector('.error-msg'); if(!box) return; if(msg===true){ wrapper.classList.remove('invalid'); box.style.display='none'; box.textContent=''; return;} wrapper.classList.add('invalid'); box.textContent=msg; box.style.display='block'; }
      const touched={};
      function validateField(key,force=false){ const {el,rule}=fields[key]; const res=rule(el.value); if(touched[key]||force) showError(key,res===true?true:res); return res===true; }
      Object.keys(fields).forEach(k=>{ const el=fields[k].el; el.addEventListener('input',()=>{ if(!touched[k]) touched[k]=true; validateField(k); updateSubmit(); }); el.addEventListener('blur',()=>{ if(el.value!=='' || k==='party'){ touched[k]=true; validateField(k); updateSubmit(); } }); });
      const submitBtn=form.querySelector('button[type=submit]');
      function updateSubmit(){ const allValid=Object.keys(fields).every(k=>fields[k].rule(fields[k].el.value)===true); submitBtn.disabled=!allValid; }
      updateSubmit();
      form.addEventListener('submit', e=>{ e.preventDefault(); let firstInvalid=null; Object.keys(fields).forEach(k=>{ touched[k]=true; if(!validateField(k,true) && !firstInvalid) firstInvalid=fields[k].el; }); if(firstInvalid){ liveErrors.textContent='Please fix the highlighted fields.'; firstInvalid.focus(); return; }
        let companions=parseInt(fields.party.el.value,10); if(isNaN(companions)||companions<0) companions=0; if(companions>1000) companions=1000; const count=companions+1;
        try{ const KEY='tourExtraRegistrations'; const store=JSON.parse(localStorage.getItem(KEY)||'{}'); store[tour||'unknown']=(store[tour||'unknown']||0)+count; localStorage.setItem(KEY, JSON.stringify(store)); }catch(err){ }
        success.style.display='block'; submitBtn.disabled=true; setTimeout(()=>{ let next; if(tour==='sundarbans') next='shundarban.html?joined='+count; else if(tour==='bandarban') next='bandarban.html?joined='+count; else if(tour==='sylhet' || tour==='sylhet-tea') next='sylhet.html?joined='+count; else if(tour==='rangamati') next='rangamati.html?joined='+count; else if(tour==='saint-martins') next='sentmartin.html?joined='+count; else next='coxs-bazar.html?tour=coxs-bazar&joined='+count; showLoaderAndNavigate(next,550); },650); });
      const backLink=document.getElementById('backLink'); if(backLink){ backLink.addEventListener('click', e=>{ const href=backLink.getAttribute('href'); if(href && !href.startsWith('#')){ e.preventDefault(); showLoaderAndNavigate(href); } }); }
    }
  }
})();

// ===== Signup Page Logic (migrated from inline script) =====
(function(){
  if(!document.body.classList.contains('signup-page')) return;
  const form=document.getElementById('signupForm');
  if(!form) return;
  let selectedGender="";
  const genderWrapper=document.getElementById('field-gender');
  const genderButtons=[...genderWrapper.querySelectorAll('.gbtn')];
  genderButtons.forEach(btn=>btn.addEventListener('click',()=>{
    genderButtons.forEach(b=>b.classList.remove('selected'));
    btn.classList.add('selected');
    selectedGender=btn.getAttribute('data-gender');
    genderWrapper.classList.remove('invalid');
    genderWrapper.querySelector('.gender-error').style.display='none';
  }));
  const fields={
    name:{el:document.getElementById('name'),rule:v=>v.trim().length>=3||'Name must be at least 3 characters'},
    email:{el:document.getElementById('email'),rule:v=>(/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/).test(v.trim())||'Enter a valid email'},
    password:{el:document.getElementById('password'),rule:v=>v.length>=6||'Password must be ≥ 6 chars'},
    password2:{el:document.getElementById('password2'),rule:v=>v===fields.password.el.value||'Passwords do not match'}
  };
  function showError(k,msg){const mapId=k==='password'? 'pass': (k==='password2'?'pass2':k); const wrap=document.getElementById('field-'+mapId);if(!wrap) return;const box=wrap.querySelector('.error-msg');if(!box) return; if(msg===true){wrap.classList.remove('invalid');box.style.display='none';box.textContent='';return;}wrap.classList.add('invalid');box.textContent=msg;box.style.display='block';}
  const touched={};
  function validate(k,force){const {el,rule}=fields[k];const res=rule(el.value); if(touched[k]||force) showError(k,res===true?true:res); return res===true;}
  Object.keys(fields).forEach(k=>{fields[k].el.addEventListener('input',()=>{ if(!touched[k]) touched[k]=true; validate(k); if(k==='password'&&touched.password2) validate('password2',true); }); fields[k].el.addEventListener('blur',()=>{touched[k]=true; validate(k,true); if(k==='password') validate('password2',true);});});
  form.addEventListener('submit',e=>{e.preventDefault();let ok=true;Object.keys(fields).forEach(k=>{touched[k]=true;if(!validate(k,true)) ok=false;}); if(!selectedGender){ genderWrapper.classList.add('invalid'); genderWrapper.querySelector('.gender-error').style.display='block'; ok=false; } if(!ok) return; try{const users=JSON.parse(localStorage.getItem('rsUsers')||'[]');users.push({n:fields.name.el.value.trim(),e:fields.email.el.value.trim(),p:fields.password.el.value,g:selectedGender});localStorage.setItem('rsUsers',JSON.stringify(users));alert('Account created! You can login now.');location.href='index.html#login';}catch(err){alert('Could not save account locally.');}});
  const toLogin=document.getElementById('toLogin'); if(toLogin){ toLogin.addEventListener('click',e=>{e.preventDefault();location.href='index.html#login';}); }
})();
