var Pagination = function(pagiOutputId, settings) {
    this.settings = $.extend({}, Pagination.Defaults, settings);
    this.pagiOutput = $(pagiOutputId);
    this.createLinks = function(paginationJSON) {
        var links = paginationJSON,
            pagination = this.pagiOutput,
            that = this;

        if (links.total_pages == 1) {
            pagination.hide();
        } else {
            pagination.find('*').remove();
            pagination.append(getPositionButton('first'))
                      .append(getPositionButton('prev'));
            for (var i = 0; i < links.total_pages;) {
                    i += 1;
                    if (i != links.current_page) {
                        pagination.append(getAnchor(i, '[' + i + ']'));
                    } else {
                        pagination.append($('<strong/>').text('[' + i + ']'));
                    }
            }
            pagination.append(getPositionButton('next'))
                      .append(getPositionButton('last'));
        }
       function getPositionButton(position) {
            var is_enabled = links[position + '_page'],
                src = that.settings.imgSrcPrefix + position + ((is_enabled) ? '_enabled' : '_disabled') + that.settings.imgSrcSuffix,
                img = $('<img/>')
                        .attr('src', src)
                        .attr('alt', position);
           if (is_enabled) {
               return getAnchor(is_enabled, img);
           } else {
               return img;
           }
        }

        function getAnchor(id, content) {
           var anchor = $('<a>')
                        .attr('href', '#')
                        .html(content)
                        .click(function(evt) {
                              evt.preventDefault();
                              that.request(id);
                         });
              return anchor;
        }
};
};

Pagination.prototype.request = function(pageId) {
        var query =  (pageId == undefined) ? '' : 'page='+pageId,
        that = this;
        this.settings.before();
            $.getJSON(that.settings.url, query + '&limit=' + that.settings.limit, function(data, status) {
                var pagination = data['pagination'];
                delete data['pagination'];
                that.settings.callback(data);
                that.createLinks(pagination);
            });
};

Pagination.prototype.getPaginationLinks = function() {
    return this.pagiOutput;
};
Pagination.prototype.getLoadMsg = function() {
    return this.settings.loadMsg;
};
Pagination.prototype.getSuccessMsg = function() {
    return this.settings.successMsg;
};
Pagination.Defaults = {
    imgSrcPrefix : '/kohana/media/img/',
    imgSrcSuffix : '_mini.png',
    url : '/kohana/admin/pages/ajax_get_pages',
    limit : 8,
    callback : function(data) {
        alert(data);
    },
    before : function() {

    }
};


