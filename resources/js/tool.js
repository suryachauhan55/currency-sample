Nova.booting((Vue, router, store) => {
  router.addRoutes([
    {
      name: 'sample',
      path: '/sample',
      component: require('./components/Tool'),
    },
  ])
})
