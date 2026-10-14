/**
 * Sound Creations: WhatsApp chat card + lead tracking for Google Analytics 4.
 *
 * Lead events sent to GA4 (via the existing gtag from Rank Math; no new tag):
 *   whatsapp_click  - any WhatsApp contact: chat-card send, mobile-bar button,
 *                     or any wa.me / api.whatsapp.com link on a page.
 *   generate_lead   - an enquiry form was received (the enquiries plugin
 *                     redirects back with ?sc_sent=1 after a successful send).
 *   phone_click     - a tel: link was tapped.
 * Mark whatsapp_click and generate_lead as key events in GA4 Admin.
 */
( function () {
	'use strict';

	function track( name, params ) {
		params = params || {};
		params.page_path = window.location.pathname;
		try {
			if ( typeof window.gtag === 'function' ) {
				window.gtag( 'event', name, params );
			} else {
				window.dataLayer = window.dataLayer || [];
				window.dataLayer.push( { event: name, params: params } );
			}
		} catch ( e ) {}
	}
	window.scTrackLead = track;

	/* ---------- Form sends: ?sc_sent=1 after a successful enquiry ---------- */
	function trackFormSuccess() {
		var url;
		try { url = new URL( window.location.href ); } catch ( e ) { return; }
		if ( url.searchParams.get( 'sc_sent' ) !== '1' ) { return; }
		var path = url.pathname.replace( /\/+$/, '' ) || '/';
		var form = path.split( '/' ).pop() || 'home';
		track( 'generate_lead', { lead_source: 'form', form_name: form } );
		// Drop the flag so a refresh or shared link is not counted again.
		url.searchParams.delete( 'sc_sent' );
		try { window.history.replaceState( null, '', url.pathname + url.search + url.hash ); } catch ( e ) {}
	}

	/* ---------- Clicks on WhatsApp and phone links anywhere ---------- */
	function trackLinkClicks() {
		document.addEventListener( 'click', function ( e ) {
			var a = e.target.closest ? e.target.closest( 'a[href]' ) : null;
			if ( a === null ) { return; }
			// The chat card's own button opens the card; its send is tracked separately.
			if ( a.classList.contains( 'sc-wa__fab' ) && document.documentElement.classList.contains( 'sc-wa-js' ) ) { return; }
			var href = a.getAttribute( 'href' ) || '';
			if ( /^https?:\/\/(wa\.me|api\.whatsapp\.com|web\.whatsapp\.com)\//i.test( href ) ) {
				var where = 'page_link';
				if ( a.closest( '.sc-tabbar' ) ) { where = 'mobile_bar'; }
				else if ( a.closest( '.sc-wa' ) ) { where = 'chat_button'; }
				else if ( a.closest( 'header' ) ) { where = 'header'; }
				else if ( a.closest( 'footer' ) ) { where = 'footer'; }
				track( 'whatsapp_click', { link_location: where } );
			} else if ( /^tel:/i.test( href ) ) {
				var loc = a.closest( '.sc-tabbar' ) ? 'mobile_bar' : ( a.closest( 'header' ) ? 'header' : ( a.closest( 'footer' ) ? 'footer' : 'page_link' ) );
				track( 'phone_click', { link_location: loc } );
			}
		}, true );
	}

	/* ---------- WhatsApp chat card ---------- */
	function initChat() {
		var root = document.querySelector( '[data-sc-wa]' );
		if ( root === null ) { return; }
		document.documentElement.classList.add( 'sc-wa-js' );
		var fab = root.querySelector( '.sc-wa__fab' ),
			panel = root.querySelector( '.sc-wa__panel' ),
			form = root.querySelector( '.sc-wa__form' ),
			text = root.querySelector( 'textarea' ),
			teaser = root.querySelector( '.sc-wa__teaser' ),
			scrim = root.querySelector( '.sc-wa__scrim' ),
			phone = window.matchMedia( '(max-width: 782px)' ),
			number = root.getAttribute( 'data-number' );
		var store = {
			get: function ( k ) { try { return window.sessionStorage.getItem( k ); } catch ( e ) { return null; } },
			set: function ( k, v ) { try { window.sessionStorage.setItem( k, v ); } catch ( e ) {} }
		};

		// Online status from the Nairobi opening hours in Settings.
		try {
			var hours = JSON.parse( root.getAttribute( 'data-hours' ) || '{}' );
			var parts = new Intl.DateTimeFormat( 'en-GB', { weekday: 'short', hour: 'numeric', minute: '2-digit', hourCycle: 'h23', timeZone: 'Africa/Nairobi' } ).formatToParts( new Date() );
			var p = {};
			parts.forEach( function ( x ) { p[ x.type ] = x.value; } );
			var mins = parseInt( p.hour, 10 ) * 60 + parseInt( p.minute, 10 );
			var today = hours[ p.weekday ];
			var online = Array.isArray( today ) && mins >= today[0] && mins < today[1];
			root.classList.toggle( 'is-online', online );
			var st = root.querySelector( '.sc-wa__status' );
			if ( st ) { st.textContent = root.getAttribute( online ? 'data-open-text' : 'data-closed-text' ) || st.textContent; }
			var tm = root.querySelector( '.sc-wa__time' );
			if ( tm ) { tm.textContent = p.hour + ':' + p.minute; }
		} catch ( e ) {}

		function grow() { text.style.height = 'auto'; text.style.height = Math.min( text.scrollHeight, 120 ) + 'px'; }
		function hideTeaser() { if ( teaser ) { teaser.hidden = true; } store.set( 'scWaTeaser', '1' ); }
		function open() {
			hideTeaser();
			panel.hidden = false;
			root.classList.add( 'is-open' );
			// Phones: bottom sheet with a dimmed backdrop and the page held still.
			if ( phone.matches ) {
				if ( scrim ) { scrim.hidden = false; }
				document.documentElement.classList.add( 'sc-wa-sheet-open' );
			}
			fab.setAttribute( 'aria-expanded', 'true' );
			if ( window.matchMedia( '(min-width: 783px)' ).matches ) { text.focus(); }
			else { var c = root.querySelector( '.sc-wa__close' ); if ( c ) { c.focus(); } }
			track( 'whatsapp_chat_open', {} );
		}
		function close( refocus ) {
			panel.hidden = true;
			root.classList.remove( 'is-open' );
			if ( scrim ) { scrim.hidden = true; }
			document.documentElement.classList.remove( 'sc-wa-sheet-open' );
			fab.setAttribute( 'aria-expanded', 'false' );
			if ( refocus ) { fab.focus(); }
		}

		fab.addEventListener( 'click', function ( e ) {
			e.preventDefault();
			if ( panel.hidden ) { open(); } else { close( true ); }
		} );
		// The mobile quick-action bar's WhatsApp button opens the same card.
		document.querySelectorAll( '[data-sc-wa-open]' ).forEach( function ( btn ) {
			btn.addEventListener( 'click', function ( e ) { e.preventDefault(); e.stopPropagation(); open(); } );
		} );
		root.querySelector( '.sc-wa__close' ).addEventListener( 'click', function () { close( true ); } );
		if ( scrim ) { scrim.addEventListener( 'click', function () { close( true ); } ); }
		document.addEventListener( 'keydown', function ( e ) { if ( e.key === 'Escape' && panel.hidden === false ) { close( true ); } } );
		document.addEventListener( 'click', function ( e ) {
			if ( panel.hidden === false && ( root.contains( e.target ) === false || e.target === scrim ) && ( e.target.closest && e.target.closest( '[data-sc-wa-open]' ) ) === null ) { close( false ); }
		} );

		root.querySelectorAll( '.sc-wa__chip' ).forEach( function ( chip ) {
			chip.addEventListener( 'click', function () {
				root.querySelectorAll( '.sc-wa__chip' ).forEach( function ( c ) { c.classList.remove( 'is-picked' ); } );
				chip.classList.add( 'is-picked' );
				text.value = chip.textContent.trim() + '. ';
				grow();
				text.focus();
				try { text.setSelectionRange( text.value.length, text.value.length ); } catch ( e ) {}
			} );
		} );
		text.addEventListener( 'input', grow );
		text.addEventListener( 'keydown', function ( e ) {
			if ( e.key === 'Enter' && e.shiftKey === false && window.matchMedia( '(min-width: 783px)' ).matches ) {
				e.preventDefault();
				if ( form.requestSubmit ) { form.requestSubmit(); } else { form.dispatchEvent( new Event( 'submit', { cancelable: true } ) ); }
			}
		} );
		form.addEventListener( 'submit', function ( e ) {
			e.preventDefault();
			var msg = text.value.trim();
			var picked = root.querySelector( '.sc-wa__chip.is-picked' );
			var url = 'https://wa.me/' + number + ( msg ? '?text=' + encodeURIComponent( msg ) : '' );
			track( 'whatsapp_click', { link_location: 'chat_send', topic: picked ? picked.textContent.trim() : 'custom' } );
			// window.open with "noopener" returns null, which used to open WhatsApp twice.
			var w = window.open( url, '_blank' );
			if ( w ) { try { w.opener = null; } catch ( err ) {} } else { window.location.href = url; }
			text.value = '';
			grow();
			close( false );
		} );

		// One friendly nudge per visit, after 15 seconds, not on contact or quote pages.
		if ( teaser && store.get( 'scWaTeaser' ) === null && /\/(contact|request-a-quote|request-a-consultation)\/?$/.test( window.location.pathname ) === false ) {
			window.setTimeout( function () { if ( panel.hidden && store.get( 'scWaTeaser' ) === null ) { teaser.hidden = false; } }, 15000 );
			teaser.addEventListener( 'click', function ( e ) {
				if ( e.target.closest( '.sc-wa__teaser-close' ) ) { hideTeaser(); } else { open(); }
			} );
		}
	}

	function boot() {
		trackFormSuccess();
		trackLinkClicks();
		initChat();
	}
	if ( document.readyState === 'loading' ) { document.addEventListener( 'DOMContentLoaded', boot ); } else { boot(); }
}() );
