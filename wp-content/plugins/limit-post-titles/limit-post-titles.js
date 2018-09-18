/*-----------------------------------
| Jesus is coming. Look busy.
------------------------------------*/
(function(){

	var Limiter = function(){
		var limiter = {
			limit: window.sr_post_titles.limit,
			bootstrap: function(){
				this.el = document.getElementById('titlewrap');
				this.submitBtn = document.getElementById('publish');
				this.postForm = document.getElementById('post');
				if(this.el) this.appendCounter();
			},
			appendCounter: function(){
				this.counter = document.createElement('span');
				this.counter.appendChild(document.createTextNode(''));
				this.counter.id = 'sr-title-limiter';
				this.el.appendChild(this.counter);
				this.titleInput = this.el.getElementsByTagName('input')[0];
				this.run();
			},
			setCounter: function(){
				this.counter.childNodes[0].nodeValue = this.getLength();
				this.setClasses();
			},
			setClasses: function(){
				if(parseInt(this.getLength(), 10) < 0){
					this.counter.style.color = 'red';
					this.submitBtn.className = 'button button-primary-disabled button-large';
				} else {
					this.counter.style.color = '#999';
					this.submitBtn.className = 'button button-primary button-large';
				}
			},
			getLength: function(){
				return this.limit-this.titleInput.value.length;
			},
			checkLimit: function(e){
				if(this.getLength() < 1){
					window.alert('Your title must be below '+this.limit+' characters.');
					e.stopImmediatePropagation();
					e.preventDefault();
					return false;
				}
			},
			run: function(){
				this.setCounter();
				this.titleInput.addEventListener('keyup', this.setCounter.bind(this));
				this.submitBtn.addEventListener('click', this.checkLimit.bind(this));
				this.postForm.addEventListener('submit', this.checkLimit.bind(this));
			}
		};
		this.init = function(){
			limiter.bootstrap();
		};
	};

	// Call on page load
	document.addEventListener("DOMContentLoaded",function(event){
		var limiter = new Limiter();
		limiter.init();
	});

})();
