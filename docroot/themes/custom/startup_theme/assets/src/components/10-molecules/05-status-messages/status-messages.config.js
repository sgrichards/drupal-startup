module.exports = {
  context: {
    type: 'status',
    messages: [
      'This is message one',
      'This is message two',
      'This is message three',
    ],
  },
  default: 'status',
  variants: [
    {
      name: 'status',
    },
    {
      name: 'warning',
      context: {
        type: 'warning',
      },
    },
    {
      name: 'error',
      context: {
        type: 'error',
      },
    },
  ],
};
