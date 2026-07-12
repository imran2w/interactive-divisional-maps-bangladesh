(function () {
	const divisionIdMap = {
		barisal: 'borishal',
		chittagong: 'chittagong',
		dhaka: 'dhaka',
		khulna: 'khulna',
		mymensingh: 'mymensingh',
		rajshahi: 'rajshahi',
		rangpur: 'rangpur',
		sylhet: 'sylhet',
	};

	function loadSvg(container) {
		const svgUrl = container.dataset.svgUrl;
		if ( ! svgUrl ) {
			return;
		}

		const st1Color = container.dataset.st1Color || '';
		const st3Color = container.dataset.st3Color || '';
		const hoverColor = container.dataset.hoverColor || '';

		const divisionUrls = {
			barisal: container.dataset.barisal || '#',
			chittagong: container.dataset.chittagong || '#',
			dhaka: container.dataset.dhaka || '#',
			khulna: container.dataset.khulna || '#',
			mymensingh: container.dataset.mymensingh || '#',
			rajshahi: container.dataset.rajshahi || '#',
			rangpur: container.dataset.rangpur || '#',
			sylhet: container.dataset.sylhet || '#',
		};

		fetch( svgUrl, { credentials: 'same-origin' } )
			.then( function ( response ) {
				if ( ! response.ok ) {
					throw new Error( 'Failed to load SVG.' );
				}

				return response.text();
			} )
			.then( function ( svgText ) {
				container.innerHTML = svgText;
				const svgElement = container.querySelector( 'svg' );
				if ( ! svgElement ) {
					return;
				}

				if ( st1Color || st3Color || hoverColor ) {
					const hoverSelectors = Object.keys( divisionIdMap ).map( function ( division ) {
						return '#' + divisionIdMap[ division ] + ':hover path:not(.st17):not(.st19)';
					} ).join( ',' );

					const cssRules = [];
					if ( st1Color ) {
						cssRules.push( '.st1{fill:' + st1Color + ';}' );
					}
					if ( st3Color ) {
						cssRules.push( '.st3,.st4,.st5,.st6,.st7,.st8,.st9,.st10,.st11,.st13,.st14{fill:' + st3Color + ';}' );
					}
					if ( hoverColor ) {
						cssRules.push( hoverSelectors + '{fill:' + hoverColor + ';}' );
					}

					const style = document.createElementNS( 'http://www.w3.org/2000/svg', 'style' );
					style.textContent = cssRules.join( '' );
					svgElement.appendChild( style );
				}

				Object.keys( divisionIdMap ).forEach( function ( division ) {
					const href = divisionUrls[ division ];
					if ( ! href || href === '#' ) {
						return;
					}

					const region = svgElement.querySelector( '#' + divisionIdMap[ division ] ) || svgElement.querySelector( '#' + division );
					if ( ! region ) {
						return;
					}

					const link = region.querySelector( 'a' ) || region.closest( 'a' );
					if ( link ) {
						link.setAttribute( 'href', href );
						link.setAttributeNS( 'http://www.w3.org/1999/xlink', 'href', href );
						return;
					}

					region.style.cursor = 'pointer';
					region.setAttribute( 'role', 'link' );
					region.setAttribute( 'tabindex', '0' );
					region.addEventListener( 'click', function () {
						window.location.href = href;
					} );
					region.addEventListener( 'keydown', function ( event ) {
						if ( event.key === 'Enter' || event.key === ' ' ) {
							event.preventDefault();
							window.location.href = href;
						}
					} );
				} );
			} )
			.catch( function () {
				container.classList.add( 'interactiveMapsBd--failed' );
			} );
	}

	function init() {
		document.querySelectorAll( '.interactiveMapsBd[data-svg-url]' ).forEach( loadSvg );
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', init );
		return;
	}

	init();
}());
