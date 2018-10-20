/* FYI: External js files used too. */

var winWidth;
$(window).resize(function(){
    winWidth = window.innerWidth;
});

// init controller
var controller = new ScrollMagic.Controller();

var ease = Power3.easeInOut;

var tweenSplitSection = new TimelineMax();
tweenSplitSection.add([
  TweenMax.fromTo(".deck1 .bg.top", 0.5, 
    {
      x: 0,
      ease: ease
    },
    {
      xPercent: -100,
      ease: ease
    }),
  TweenMax.fromTo(".deck1 .bg.bottom", 0.5, 
    {
      xPercent: 0,
      ease: ease
    },
    {
      xPercent: 100,
      ease: ease
    })
]);

// build scene
var sceneSpiltSection = new ScrollMagic.Scene({
  triggerElement: ".deck1",
  triggerHook: 'onLeave',
  duration: '25%'
})
  .setTween(tweenSplitSection)
  //.addIndicators({ name: "Split section (duration: 500)" })
  .setPin(".deck1")
  .addTo(controller);