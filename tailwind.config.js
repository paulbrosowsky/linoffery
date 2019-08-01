module.exports = {
    theme: { 
        aspectRatio: { // defaults to {}
        'square': [1, 1],
        '16/9': [16, 9],
        '4/3': [4, 3],
        '21/9': [21, 9],
        },
    },
    variants: {
        aspectRatio: ['responsive'], // defaults to ['responsive']
    },
    plugins: [
        require('tailwindcss-aspect-ratio')(),
    ]
}
