! function(e) {
    "use strict";
    var t, i, n, a = window.BlankelementsLibData || {};
    i = {
        LibraryLayoutView: null,
        LibraryHeaderView: null,
        LibraryLoadingView: null,
        LibraryErrorView: null,
        LibraryBodyView: null,
        LibraryCollectionView: null,
        FiltersCollectionView: null,
        FavouriteView: null,
        LibraryTabsCollectionView: null,
        LibraryTabsItemView: null,
        FiltersItemView: null,
        LibraryTemplateItemView: null,
        LibraryInsertTemplateBehavior: null,
        LibraryTabsCollection: null,
        LibraryCollection: null,
        CategoriesCollection: null,
        LibraryTemplateModel: null,
        CategoryModel: null,
        TabModel: null,
        KeywordsModel: null,
        KeywordsView: null,
        LibraryPreviewView: null,
        LibraryHeaderBack: null,
        LibraryHeaderInsertButton: null,
        LibraryProButton: null,
        init: function() {
            var e = this;
            e.LibraryTemplateModel = Backbone.Model.extend({
                defaults: {
                    template_id: 0,
                    name: "",
                    title: "",
                    thumbnail: "",
                    preview: "",
                    source: "",
                    package: "",
                    livelink: "",
                    categories: [],
                    keywords: [],
                    description: "",
                }
            }), e.CategoryModel = Backbone.Model.extend({
                defaults: {
                    slug: "",
                    title: ""
                }
            }), e.TabModel = Backbone.Model.extend({
                defaults: {
                    slug: "",
                    title: ""
                }
            }), e.KeywordsModel = Backbone.Model.extend({
                defaults: {
                    keywords: {}
                }
            }), e.LibraryCollection = Backbone.Collection.extend({
                model: e.LibraryTemplateModel
            }), e.CategoriesCollection = Backbone.Collection.extend({
                model: e.CategoryModel
            }), e.LibraryTabsCollection = Backbone.Collection.extend({
                model: e.TabModel
            }), e.LibraryLoadingView = Marionette.ItemView.extend({
                id: "blankelements-template-library-loading",
                template: "#view-blankelements-template-library-loading"
            }), e.LibraryErrorView = Marionette.ItemView.extend({
                id: "blankelements-template-library-error",
                template: "#view-blankelements-template-library-error"
            }), e.LibraryHeaderView = Marionette.LayoutView.extend({
                id: "blankelements-template-library-header",
                template: "#view-blankelements-template-library-header",
                ui: {
                    closeModal: "#blankelements-template-library-header-close-modal"
                },
                events: {
                    "click @ui.closeModal": "onCloseModalClick"
                },
                regions: {
                    logoArea: "#blankelements-template-library-header-logo",
                    headerTabs: "#blankelements-template-library-header-tabs",
                    headerActions: "#blankelements-template-library-header-actions",
                    backToTemplate: "#blankelements-back-to-template"
                },
                onCloseModalClick: function() {
                    t.closeModal()
                }
            }), e.LibraryPreviewView = Marionette.ItemView.extend({
                template: "#view-blankelements-template-library-preview",
                id: "blankelements-template-library-preview",
                ui: {
                    img: ".blankelements-template-preview-img",
                    title: ".blankelements-template-title",
                    description: ".blankelements-template-description",
                    info_wrapper: ".blankelements-template-info",
                    back_button: ".blankelements-template-library-back",
                    insertButton: ".blankelements-template-library-template-insert"
                },
                events: {
                    "click @ui.back_button": "onBackClick",
                    "click @ui.insertButton": "onInsertButtonClick"
                },
                onBackClick: function() {
                    t.setPreview("back")
                },
                onInsertButtonClick: function() {
                    jQuery('#blankelements-template-library-header-actions .blankelements-template-library-template-insert').trigger('click');
                },
                onRender: function() {
                    this.ui.img.attr("src", this.ui.img.attr("src") + this.getOption("preview"));
                    this.ui.title.text(this.getOption("title"));
                    this.ui.description.text(this.getOption("description"));
                    this.ui.info_wrapper.attr('data-template-id',this.getOption("template_id"));
                    if( this.getOption('is_favourite') ) {
                        this.ui.info_wrapper.find('.blankelements-template-library-favorite-wrapper').addClass('added');
                        this.ui.info_wrapper.find('.blankelements_favourite_icon').removeClass('.eicon-heart-o').addClass('eicon-heart');
                    } else {
                        this.ui.info_wrapper.find('.blankelements-template-library-favorite-wrapper').removeClass('added');
                        this.ui.info_wrapper.find('.blankelements_favourite_icon').removeClass('eicon-heart').addClass('eicon-heart-o');
                    }
                    if( 'pro' === this.getOption('package') ) {
                        this.ui.info_wrapper.find('.blankelements-pro-badge').text('PRO');
                        this.ui.insertButton.remove();
                    }

                },
            }), e.LibraryHeaderBack = Marionette.ItemView.extend({
            template: "#view-blankelements-template-library-header-back",
                id: "blankelements-template-library-header-back",
                ui: {
                    button: "button"
                },
                events: {
                    "click @ui.button": "onBackClick"
                },
                onBackClick: function() {
                    t.setPreview("back")
                }
            }), e.LibraryInsertTemplateBehavior = Marionette.Behavior.extend({
                ui: {
                    insertButton: ".blankelements-template-library-template-insert"
                },
                events: {
                    "click @ui.insertButton": "onInsertButtonClick"
                },
                onInsertButtonClick: function() {
                    var version = elementor.config.version;
                    if (version > '2.7.4') {
                        var e = this.view.model;
                        t.layout.showLoadingView();
                        var i, n, a;
                        i = e.get("template_id"), a = {
                            unique_id: i,
                            data: {
                                edit_mode: !0,
                                display: !0,
                                template_id: i,
                                source: 'blankelements_api',
                                tab: t.getTab(),
                                page_settings: !0
                            }
                        }, (n = {
                            success: function(e) {
                                $e.run("document/elements/import", {
                                    model: window.elementor.elementsModel,
                                    data: e,
                                    options: {}
                                }), t.closeModal()
                            }
                        }) && jQuery.extend(!0, a, n), elementorCommon.ajax.addRequest("get_template_data", a)
                    } else {
                        var e = this.view.model,
                        i = {};
                        t.layout.showLoadingView(), elementor.templates.requestTemplateContent(e.get("source"), e.get("template_id"), {
                            data: {
                                tab: t.getTab(),
                                page_settings: !0
                            },
                            success: function(n) {
                                (t.closeModal(), elementor.channels.data.trigger("template:before:insert", e), null !== t.atIndex && (i.at = t.atIndex), elementor.sections.currentView.addChildModel(n.content, i), n.page_settings && elementor.settings.page.model.set(n.page_settings), elementor.channels.data.trigger("template:after:insert", e), t.atIndex = null)
                            }
                        })
                    }
                }
            }), e.LibraryHeaderInsertButton = Marionette.ItemView.extend({
                template: "#view-blankelements-template-library-insert-button",
                id: "blankelements-template-library-insert-button",
                behaviors: {
                    insertTemplate: {
                        behaviorClass: e.LibraryInsertTemplateBehavior
                    }
                }
            }), e.LibraryProButton = Marionette.ItemView.extend({
                template: "#view-blankelements-template-library-pro-button",
                id: "blankelements-template-library-pro-button"
            }), e.LibraryTemplateItemView = Marionette.ItemView.extend({
                template: "#view-blankelements-template-library-item",
                initialize: function(options) { 
                    _.bindAll(this, 'beforeRender', 'render', 'afterRender'); 
                    var _this = this; 
                    this.render = _.wrap(this.render, function(render) { 
                        _this.beforeRender(); 
                        render(); 
                        _this.afterRender(); 
                        return _this; 
                    }); 
                }, 
                className: function() {
                    var e = " blankelements-template-has-url",
                        t = " elementor-template-library-template-";
                    return "" === this.model.get("preview") && (e = " blankelements-template-no-url"), "blankelements-local" === this.model.get("source") ? t += "local" : t += "remote", "elementor-template-library-template" + t + e
                },
                ui: function() {
                    return {
                        previewButton: ".elementor-template-library-template-preview"
                    }
                },
                events: function() {
                    return {
                        "click @ui.previewButton": "onPreviewButtonClick"
                    }
                },
                onPreviewButtonClick: function() {
                    "" !== this.model.get("preview") && t.setPreview(this.model)
                },
                beforeRender: function() { 
                 }, 
                afterRender: function() {
                    let template_id = this.model.attributes.template_id.toString();
                    if(blankelements_js_data.favourite_templates.includes(template_id)) {
                        setTimeout(function(){
                            jQuery('.blankelements-template-item-wrapper[data-template-id="' + template_id + '"] .blankelements-template-library-favorite-wrapper').addClass('added');
                            jQuery('.blankelements-template-item-wrapper[data-template-id="' + template_id + '"] .blankelements_favourite_icon').removeClass('.eicon-heart-o').addClass('eicon-heart');
                        },500);
                    }
                }, 
                behaviors: {
                    insertTemplate: {
                        behaviorClass: e.LibraryInsertTemplateBehavior
                    }
                }
            }), e.FiltersItemView = Marionette.ItemView.extend({
                template: "#view-blankelements-template-library-filters-item",
                tagName: 'select',
                className: function() {
                    return "blankelements-filter-item"
                },
                onRender: function () {
                    // Get rid of that pesky wrapping-div.
                    // Assumes 1 child element present in template.
                    this.$el = this.$el.children();
                    // Unwrap the element to prevent infinitely 
                    // nesting elements during re-render.
                    this.$el.unwrap();
                    this.setElement(this.$el);
                },
            }), e.LibraryTabsItemView = Marionette.ItemView.extend({
                template: "#view-blankelements-template-library-tabs-item",
                className: function() {
                    return "elementor-template-library-menu-item"
                },
                ui: function() {
                    return {
                        tabsLabels: "label",
                        tabsInput: "input"
                    }
                },
                events: function() {
                    return {
                        "click @ui.tabsLabels": "onTabClick"
                    }
                },
                onRender: function() {
                    this.model.get("slug") === t.getTab() && this.ui.tabsInput.attr("checked", "checked")
                },
                onTabClick: function(e) {
                    var i = jQuery(e.target);
                    t.setTab(i.val()), t.setFilter("keyword", "")
                }
            }), e.LibraryCollectionView = Marionette.CompositeView.extend({
                template: "#view-blankelements-template-library-templates",
                id: "blankelements-template-library-templates",
                childViewContainer: "#blankelements-template-library-templates-container",
                initialize: function() {
                    this.listenTo(t.channels.templates, "filter:change", this._renderChildren)
                },
                filter: function(e) {
                    var i = t.getFilter("category"),
                        n = t.getFilter("keyword");
                    return !i && !n || (n && !i ? _.contains(e.get("keywords"), n) : i && !n ? _.contains(e.get("categories"), i) : _.contains(e.get("categories"), i) && _.contains(e.get("keywords"), n))
                },
                getChildView: function(t) {
                    return e.LibraryTemplateItemView
                },
                onRenderCollection: function() {
                    var i = this.$childViewContainer,
                        n = this.$childViewContainer.children(),
                        a = t.getTab();
                    "blankelements_pages" !== a && "local" !== a && setTimeout(function() {
                        e.masonry.init({
                            container: i,
                            items: n
                        })
                    }, 200)
                }
            }), e.LibraryTabsCollectionView = Marionette.CompositeView.extend({
                template: "#view-blankelements-template-library-tabs",
                childViewContainer: "#blankelements-template-library-tabs-items",
                initialize: function() {},
                getChildView: function(t) {
                    return e.LibraryTabsItemView
                }
            }), e.FiltersCollectionView = Marionette.CompositeView.extend({
                id: "blankelements-template-library-filters",
                template: "#view-blankelements-template-library-filters",
                childViewContainer: "#blankelements-template-library-filters-container",
                getChildView: function(t) {
                    return e.FiltersItemView
                },
                events: {
                        "change #blankelements-template-library-filters-container": "onFilterClick"
                },
                onFilterClick: function(e) {
                    var i = jQuery(e.target);
                    t.setFilter("category", i.val())
                }   
            }),e.FavouriteView = Marionette.CompositeView.extend({
                id: "blankelements-template-library-filters",
                template: "#view-blankelements-template-library-filters",
                childViewContainer: "#blankelements-template-library-filters-container",
                getChildView: function(t) {
                    return e.FiltersItemView
                },
                events: {
                        "change #blankelements-template-library-filters-container": "onFilterClick"
                },
                onFilterClick: function(e) {
                    var i = jQuery(e.target);
                    t.setFilter("category", i.val())
                }   
            }), e.LibraryBodyView = Marionette.LayoutView.extend({
                id: "blankelements-template-library-content",
                className: function() {
                    return "library-tab-" + t.getTab()
                },
                template: "#view-blankelements-template-library-content",
                regions: {
                    contentTemplates: ".blankelements-templates-list",
                    contentFilters: ".blankelements-filters-list",
                    contentKeywords: ".blankelements-keywords-list"
                }
            }), e.LibraryLayoutView = Marionette.LayoutView.extend({
                el: "#blankelements-template-library-modal",
                regions: a.modalRegions,
                initialize: function() {
                    this.getRegion("modalHeader").show(new e.LibraryHeaderView), this.listenTo(t.channels.tabs, "filter:change", this.switchTabs), this.listenTo(t.channels.layout, "preview:change", this.switchPreview)
                },
                switchTabs: function() {
                    this.showLoadingView(), t.setFilter("keyword", ""), t.requestTemplates(t.getTab())
                },
                switchPreview: function() {
                    var i = this.getHeaderView(),
                        n = t.getPreview();
                    if ("back" === n) return i.headerTabs.show(new e.LibraryTabsCollectionView({
                        collection: t.collections.tabs
                    })), i.headerActions.empty(), void t.setTab(t.getTab());
                    "initial" !== n ? (this.getRegion("modalContent").show(new e.LibraryPreviewView({
                        preview: n.get("preview"),
                        template_id: n.get("template_id"),
                        title: n.get("title"),
                        description: n.get("description"),
                        is_favourite: blankelements_js_data.favourite_templates.includes(n.get("template_id").toString()),
                        package: n.get("package"),
                        source: n.get("source"),
                    })), i.headerTabs.show(new e.LibraryHeaderBack), "pro" != n.get("package") ? i.headerActions.show(new e.LibraryHeaderInsertButton({
                        model: n
                    })) : i.headerActions.show(new e.LibraryProButton({
                        model: n
                    }))) : i.headerActions.empty()
                },
                getHeaderView: function() {
                    return this.getRegion("modalHeader").currentView
                },
                getContentView: function() {
                    return this.getRegion("modalContent").currentView
                },
                showLoadingView: function() {
                    this.modalContent.show(new e.LibraryLoadingView)
                },
                showLicenseError: function() {
                    this.modalContent.show(new e.LibraryErrorView)
                },
                showTemplatesView: function(i, n, a) {
                    this.getRegion("modalContent").show(new e.LibraryBodyView);
                    var l = this.getContentView(),
                        r = this.getHeaderView();
                    new e.KeywordsModel({
                        keywords: a
                    });
                    t.collections.tabs = new e.LibraryTabsCollection(t.getTabs()), r.headerTabs.show(new e.LibraryTabsCollectionView({
                        collection: t.collections.tabs
                    })), l.contentTemplates.show(new e.LibraryCollectionView({
                        collection: i
                    })), l.contentFilters.show(new e.FiltersCollectionView({
                        collection: n
                    })), l.contentFilters.show(new e.FavouriteView({
                        collection: n
                    }))
                    jQuery('#blankelements-template-library-filters-container,#blankelements-template-sort-by').select2();
                }
            })
        },
        masonry: {
            self: {},
            elements: {},
            init: function(t) {
                this.settings = e.extend(this.getDefaultSettings(), t), this.elements = this.getDefaultElements(), this.run()
            },
            getSettings: function(e) {
                return e ? this.settings[e] : this.settings
            },
            getDefaultSettings: function() {
                return {
                    container: null,
                    items: null,
                    columnsCount: 4,
                    verticalSpaceBetween: 0
                }
            },
            getDefaultElements: function() {
                return {
                    $container: jQuery(this.getSettings("container")),
                    $items: jQuery(this.getSettings("items"))
                }
            },
            run: function() {
                var e = [],
                    t = this.elements.$container.position().top,
                    i = this.getSettings(),
                    n = i.columnsCount;
                t += parseInt(this.elements.$container.css("margin-top"), 10), this.elements.$container.height(""), this.elements.$items.each(function(a) {
                    var l = Math.floor(a / n),
                        r = a % n,
                        o = jQuery(this),
                        s = o.position(),
                        c = o[0].getBoundingClientRect().height + i.verticalSpaceBetween;
                    if (l) {
                        var m = s.top - t - e[r];
                        m -= parseInt(o.css("margin-top"), 10), m *= -1, o.css("margin-top", m + "px"), e[r] += c
                    } else e.push(c)
                }), this.elements.$container.height(Math.max.apply(Math, e))
            }
        }
    }, n = {
        BlankelementsSearchView: null,
        init: function() {
            this.BlankelementsSearchView = window.elementor.modules.controls.BaseData.extend({
                onReady: function() {
                    var t = this.model.attributes.action,
                        i = this.model.attributes.query_params;
                    this.ui.select.find("option").each(function(t, i) {
                        e(this).attr("selected", !0)
                    }), this.ui.select.select2({
                        ajax: {
                            url: function() {
                                var n = "";
                                return i.length > 0 && e.each(i, function(e, t) {
                                    window.elementor.settings.page.model.attributes[t] && (n += "&" + t + "=" + window.elementor.settings.page.model.attributes[t])
                                }), ajaxurl + "?action=" + t + n
                            },
                            dataType: "json"
                        },
                        placeholder: "Please enter 3 or more characters",
                        minimumInputLength: 3
                    })
                },
                onBeforeDestroy: function() {
                    this.ui.select.data("select2") && this.ui.select.select2("destroy"), this.$el.remove()
                }
            }), window.elementor.addControlView("blankelements_search", this.BlankelementsSearchView)
        }
    }, t = {
        modal: !1,
        layout: !1,
        collections: {},
        tabs: {},
        defaultTab: "",
        channels: {},
        atIndex: null,
        init: function() {
            window.elementor.on("preview:loaded", window._.bind(t.onPreviewLoaded, t)), i.init(), n.init()
        },
        onPreviewLoaded: function() {
            let e = setInterval(() => {
                window.elementor.$previewContents.find(".elementor-add-new-section").length && (this.initAizenButton(), clearInterval(e))
            }, 100);
            window.elementor.$previewContents.on("click", ".elementor-editor-element-setting.elementor-editor-element-add", this.initAizenButton), window.elementor.$previewContents.on("click.addBlankelementsTemplate", ".add-blankelements-template", _.bind(this.showTemplatesModal, this)), this.channels = {
                templates: Backbone.Radio.channel("BLANKELEMENTS_THEME_EDITOR:templates"),
                tabs: Backbone.Radio.channel("BLANKELEMENTS_THEME_EDITOR:tabs"),
                layout: Backbone.Radio.channel("BLANKELEMENTS_THEME_EDITOR:layout")
            }, this.tabs = a.tabs, this.defaultTab = a.defaultTab
        },
        initAizenButton: function() {
            var i = window.elementor.$previewContents.find(".elementor-add-new-section"),
                n = '<div class="add-blankelements-template blankelements-wid-con"><i class="eicon-plus"></i></div>';
                i.find(".add-blankelements-template").length || (i.length && a.libraryButton && e(n).prependTo(i), window.elementor.$previewContents.on("click.addBlankelementsTemplate", ".elementor-editor-section-settings .elementor-editor-element-add", function() {
                var i = e(this).closest(".elementor-top-section"),
                    l = i.data("model-cid");
                (window.elementor.sections && window.elementor.sections.currentView.collection.length && e.each(window.elementor.sections.currentView.collection.models, function(e, i) {
                    l === i.cid && (t.atIndex = e)
                }), a.libraryButton) && i.prev(".elementor-add-section").find(".elementor-add-new-section").prepend(n)
            }))
        },
        getFilter: function(e) {
            return this.channels.templates.request("filter:" + e)
        },
        setFilter: function(e, t) {
            this.channels.templates.reply("filter:" + e, t), this.channels.templates.trigger("filter:change")
        },
        getTab: function() {
            return this.channels.tabs.request("filter:tabs")
        },
        setTab: function(e, t) {
            this.channels.tabs.reply("filter:tabs", e), t || this.channels.tabs.trigger("filter:change")
        },
        getTabs: function() {
            var e = [];
            return _.each(this.tabs, function(t, i) {
                e.push({
                    slug: i,
                    title: t.title
                })
            }), e
        },
        getPreview: function(e) {
            return this.channels.layout.request("preview")
        },
        setPreview: function(e, t) {
            this.channels.layout.reply("preview", e), t || this.channels.layout.trigger("preview:change")
        },
        getKeywords: function() {
            return _.each(this.keywords, function(e, t) {
                tabs.push({
                    slug: t,
                    title: e
                })
            }), []
        },
        showTemplatesModal: function() {
            this.getModal().show(), this.layout || (this.layout = new i.LibraryLayoutView, this.layout.showLoadingView()), this.setTab(this.defaultTab, !0), this.requestTemplates(this.defaultTab), this.setPreview("initial")
        },
        requestTemplates: function(t) {
            var n = this,
                a = n.tabs[t];
            n.setFilter("category", !1), a.data.templates && a.data.categories ? n.layout.showTemplatesView(a.data.templates, a.data.categories, a.data.keywords) : e.ajax({
                url: ajaxurl,
                type: "get",
                dataType: "json",
                data: {
                    action: "blankelements_get_layouts",
                    tab: t
                },
                success: function(e) {
                    var a = new i.LibraryCollection(e.data.templates),
                        l = new i.CategoriesCollection(e.data.categories);
                    n.tabs[t].data = {
                        templates: a,
                        categories: l,
                        keywords: e.data.keywords
                    }, n.layout.showTemplatesView(a, l, e.data.keywords)
                }
            })
        },
        closeModal: function() {
            this.getModal().hide()
        },
        getModal: function() {
            return this.modal || (this.modal = elementor.dialogsManager.createWidget("lightbox", {
                id: "blankelements-template-library-modal",
                closeButton: !1
            })), this.modal
        }
    }, e(window).on("elementor:init", t.init);

    // Custome Code
    jQuery('body').on('click', '.blankelements-template-library-favorite-wrapper', function(){
        let template_item_elem = jQuery(this).closest('.blankelements-template-item-wrapper,.blankelements-template-info');
        let template_id        = jQuery(template_item_elem).data('template-id');
        let favourite_acton    = jQuery( template_item_elem ).find('.blankelements-template-library-favorite-wrapper').hasClass( 'added' ) ? 'remove_from_favourite' : 'add_to_favourite';
        let data               = {
            action: 'blankelements_save_as_favourite',
            template_id: template_id,
            favourite_acton: favourite_acton,
            security: blankelements_js_data.security
        };
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            dataType: 'json',
            data: data,
            success: function (response) {
                if( response.success ) {
                    if( 'add_to_favourite' === favourite_acton ) {
                        blankelements_js_data.favourite_templates.push(template_id.toString());
                        jQuery( template_item_elem ).find('.blankelements-template-library-favorite-wrapper').addClass('added');
                        jQuery(template_item_elem).find('.blankelements_favourite_icon').removeClass('eicon-heart-o').addClass('eicon-heart');
                    } else if( 'remove_from_favourite' === favourite_acton ) {
                        let template_index = blankelements_js_data.favourite_templates.indexOf(template_id.toString());
                        if (template_index > -1) {
                            blankelements_js_data.favourite_templates.splice(template_index, 1);
                        }
                        jQuery( template_item_elem ).find('.blankelements-template-library-favorite-wrapper').removeClass('added');
                        jQuery(template_item_elem).find('.blankelements_favourite_icon').removeClass('eicon-heart').addClass('eicon-heart-o');
                    }
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
            }
        });
    });

    jQuery('body').on('click', '.blankelements-filter-favourite-wrapper', function(){
        let filter_action        = jQuery(this).hasClass('filtered') ? 'undo_filter' : 'do_filter';
        if( 'do_filter' === filter_action ) {
            let favorite_template = false;
            jQuery('#blankelements-template-library-templates-container .elementor-template-library-template').each(function(){
                let is_favourite = jQuery(this).find('.blankelements-template-library-favorite-wrapper').hasClass('added') ? true : false;
                if( ! is_favourite ) {
                    jQuery(this).hide('slow');
                } else {
                    jQuery(this).show('slow');
                    favorite_template = true;
                }
            });
            if( !favorite_template ) {
                jQuery('#blankelements-template-library-no-favorite-templates').show();
                jQuery('#blankelements-template-library-templates-container').hide();
            } else {
                jQuery('#blankelements-template-library-no-favorite-templates').hide();
                jQuery('#blankelements-template-library-templates-container').show();
            }
            jQuery(this).addClass('filtered').find('.blankelements_favourite_icon').removeClass('eicon-heart-o').addClass('eicon-heart');
        } else {
            jQuery(this).removeClass('filtered').find('.blankelements_favourite_icon').removeClass('eicon-heart').addClass('eicon-heart-o');
            jQuery('#blankelements-template-library-templates-container .elementor-template-library-template').show('slow');
            jQuery('#blankelements-template-library-no-favorite-templates').hide();
            jQuery('#blankelements-template-library-templates-container').show();
        }
    });

}(jQuery);
