module.exports = {
  collated: true,
  context: {
    text: 'The quick brown fox jumps over the lazy dog',
    level: 1,
  },
  default: 'h1',
  variants: [
    {
      name: 'h1',
      context: { level: 1 },
    },
    {
      name: 'h2',
      context: { level: 2 },
    },
    {
      name: 'h3',
      context: { level: 3 },
    },
    {
      name: 'h4',
      context: { level: 4 },
    },
    {
      name: 'h5',
      context: { level: 5 },
    },
    {
      name: 'h6',
      context: { level: 6 },
    },
  ],
};
