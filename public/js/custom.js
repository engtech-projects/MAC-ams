

// function createPayment(modal) {

// }

function GlobalWidget(title = '', route = '', callback = '') {

	this.modal = $('#modal-global');
	this.title = title;
    this.route = route;
    this.callback = callback;

	this.setTitle = function(title){
        this.title = title;
        return this;
    }

    this.setRoute = function(route){
        this.route = route;
        return this;
    }

    this.setCallback = function(callback){
        this.callback = callback;
        return this;
    }

    this.invoke = function () {

        if( !this.validate() ) {
            alert('check ang arguments');
            return false;
        }

        this.modal.find('.modal-title').html(this.title);
        this.modal.find('.modal-body').html('');
        this.modal.find('.modal-body').load(this.route, this.callback);
    }

    this.validate = function() {

        if( this.route && this.callback ) { return true; }
        return false
    }

    this.init = function() {
        this.invoke();
        this.modal.modal('show');
    }

    this.close = function() {
        this.modal.modal('hide');
    }
}

function payment(title, route, callback) {

	var modal = $('#modal-global');
	var title = title;
	   
    modal.find('.modal-title').html(title);
    // load content from HTML string
    // or, load content from value of data-remote url
    modal.find('.modal-body').html('');
    modal.find('.modal-body').load(route, callback);
    modal.modal('show');
    
}
