// js/store.js
// Handles product View modal + Add to Cart + Floating cart panel
(function(){
    // helper
    const $ = sel => document.querySelector(sel);
    const $$ = sel => Array.from(document.querySelectorAll(sel));
  
    // Modal elements
    const modal = $('#product-modal');
    const modalImg = $('#modal-img');
    const modalTitle = $('#modal-title');
    const modalPrice = $('#modal-price');
    const modalDesc = $('#modal-desc');
    const modalAddBtn = $('#modal-add');
    const modalClose = $('#modal-close');
    const modalClose2 = $('#modal-close-2');
  
    // Cart elements (floating)
    const cartBtn = $('.nav') ? null : null; // not used; we'll open cart via button
    const floatingCart = $('#floating-cart');
    const fcItems = $('#fc-items');
    const fcTotal = $('#fc-total');
    const fcClose = $('#fc-close');
    const fcCheckout = $('#fc-checkout');
    const fcClear = $('#fc-clear');
  
    // cart data
    let cart = JSON.parse(localStorage.getItem('concept_cart') || '{}');
  
    // utility
    function saveCart(){ localStorage.setItem('concept_cart', JSON.stringify(cart)); renderCart(); updateCartCount(); }
    function updateCartCount(){
      const totalQty = Object.values(cart).reduce((s,i)=>s + (i.qty||0), 0);
      // find any element that shows cart count — we'll update existing cart preview if any
      const preview = document.getElementById('cart-count');
      if(preview) preview.innerText = totalQty;
    }
  
    function renderCart(){
      fcItems.innerHTML = '';
      const items = Object.values(cart);
      if(items.length === 0){
        fcItems.innerHTML = '<p style="padding:12px;color:var(--muted)">Your cart is empty</p>';
        fcTotal.innerText = '0';
        return;
      }
      let total = 0;
      items.forEach(it=>{
        total += (it.price * it.qty);
        const row = document.createElement('div');
        row.className = 'fc-row';
        row.innerHTML = `
          <div class="fc-row-left">
            <img src="${it.img}" alt="${it.title}" />
          </div>
          <div class="fc-row-right">
            <div class="fc-title">${it.title}</div>
            <div class="fc-price">₹${it.price} × ${it.qty}</div>
            <div class="fc-actions">
              <button class="qty-btn" data-id="${it.id}" data-delta="-1">-</button>
              <button class="qty-btn" data-id="${it.id}" data-delta="1">+</button>
              <button class="qty-remove" data-id="${it.id}">Remove</button>
            </div>
          </div>
        `;
        fcItems.appendChild(row);
      });
      fcTotal.innerText = total;
      // bind qty handlers
      $$('.qty-btn').forEach(b => b.addEventListener('click', e=>{
        const id = e.target.dataset.id;
        const delta = Number(e.target.dataset.delta);
        changeQty(id, delta);
      }));
      $$('.qty-remove').forEach(b => b.addEventListener('click', e=>{
        removeFromCart(e.target.dataset.id);
      }));
    }
  
    function addToCartObj(obj){
      const id = String(obj.id);
      if(cart[id]) cart[id].qty += 1;
      else cart[id] = { id: obj.id, title: obj.title, price: Number(obj.price), img: obj.img, qty: 1 };
      saveCart();
      showFloatingCart(); // visual feedback
    }
    function removeFromCart(id){
      delete cart[String(id)];
      saveCart();
    }
    function changeQty(id, delta){
      const k = String(id);
      if(!cart[k]) return;
      cart[k].qty += delta;
      if(cart[k].qty <= 0) delete cart[k];
      saveCart();
    }
    function clearCart(){
      cart = {};
      saveCart();
    }
  
    // show/hide helpers
    function showModal(){ modal.classList.remove('hidden'); modal.setAttribute('aria-hidden','false'); }
    function hideModal(){ modal.classList.add('hidden'); modal.setAttribute('aria-hidden','true'); }
    function showFloatingCart(){ floatingCart.classList.remove('hidden'); floatingCart.setAttribute('aria-hidden','false'); renderCart(); updateCartCount(); }
    function hideFloatingCart(){ floatingCart.classList.add('hidden'); floatingCart.setAttribute('aria-hidden','true'); }
  
    // open modal and populate
    function openProductModal(data){
      modalImg.src = data.img || '';
      modalImg.alt = data.title || '';
      modalTitle.innerText = data.title || '';
      modalPrice.innerText = '₹' + Number(data.price || 0);
      modalDesc.innerText = data.desc || 'Product details will go here.';
      modalAddBtn.dataset.id = data.id;
      modalAddBtn.dataset.title = data.title;
      modalAddBtn.dataset.price = data.price;
      modalAddBtn.dataset.img = data.img;
      showModal();
    }
  
    // event bindings
    document.addEventListener('click', (e)=>{
      // View button
      const viewBtn = e.target.closest && e.target.closest('.view-btn');
      if(viewBtn){
        const data = {
          id: viewBtn.dataset.id,
          title: viewBtn.dataset.title,
          price: viewBtn.dataset.price,
          img: viewBtn.dataset.img,
          desc: viewBtn.dataset.desc || ''
        };
        openProductModal(data);
        return;
      }
      // Add button on card
      const addBtn = e.target.closest && e.target.closest('.add-btn');
      if(addBtn){
        const data = { id: addBtn.dataset.id, title: addBtn.dataset.title, price: addBtn.dataset.price, img: addBtn.dataset.img };
        addToCartObj(data);
        return;
      }
      // modal add
      if(e.target === modalAddBtn){
        const data = { id: modalAddBtn.dataset.id, title: modalAddBtn.dataset.title, price: modalAddBtn.dataset.price, img: modalAddBtn.dataset.img };
        addToCartObj(data);
        hideModal();
        return;
      }
      // close modal buttons
      if(e.target === modalClose || e.target === modalClose2 || e.target.classList.contains('modal-backdrop')) {
        hideModal();
        return;
      }
      // open floating cart by clicking any element with id 'open-cart'
      if(e.target && (e.target.id === 'open-cart' || e.target.closest && e.target.closest('#open-cart'))) {
        showFloatingCart();
        return;
      }
      // cart close
      if(e.target === fcClose) { hideFloatingCart(); return; }
      // checkout
      if(e.target === fcCheckout) {
        // simple confirmation
        if(Object.keys(cart).length === 0){ alert('Cart is empty'); return; }
        alert('Order placed! Total: ₹' + fcTotal.innerText);
        clearCart();
        hideFloatingCart();
        return;
      }
      if(e.target === fcClear){ clearCart(); return; }
    });
  
    // init on load
    document.addEventListener('DOMContentLoaded', ()=>{
      renderCart();
      updateCartCount();
      // bind close by ESC
      document.addEventListener('keydown', e=>{
        if(e.key === 'Escape') {
          hideModal();
          hideFloatingCart();
        }
      });
    });
  
  })();
  