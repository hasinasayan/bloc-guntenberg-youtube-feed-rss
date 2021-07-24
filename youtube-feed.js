wp.blocks.registerBlockType( 'youtube-feed/youtube-feed', {

    title: wp.i18n.__( 'Youtube frugalisme', 'text-domain' ),
    description: wp.i18n.__( 'Youtube video frugalisme feed rss', 'text-domain' ),
    icon: 'universal-access-alt',
    category: 'frugalisme',

    edit: function( props ) {
        return frugalisme_value.render_youtube
    },
    save: function( props ) {
        return null
    },

} );