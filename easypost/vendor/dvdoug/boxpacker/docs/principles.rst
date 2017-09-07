Principles of operation
=======================

Bin packing is an `NP-hard problem`_ and there is no way to always achieve an optimum solution without running through every
single permutation. But that's OK because this implementation is designed to simulate a naive human approach to the problem
rather than search for the "perfect" solution.

This is for 2 reasons:

1. It's quicker
2. It doesn't require the person actually packing the box to be given a 3D diagram
   explaining just how the items are supposed to fit.

At a high level, the algorithm works like this:

 * Pack largest (by volume) items first
 * Pack vertically up the side of the box
 * Pack side-by-side where item under consideration fits alongside the previous item
 * Only very small overhangs are allowed (10%) to prevent items bending in transit
 * The available width/height for each layer will therefore decrease as the stack of items gets taller
 * If more than 1 box is needed to accommodate all of the items, then aim for boxes of roughly equal weight
   (e.g. 3 medium size/weight boxes are better than 1 small light box and 2 that are large and heavy)

Limitations
-----------

 * Items are assumed to be shipped flat (e.g. books, fragile items). The algorithm as implemented therefore considers
   simple 2D rotation of items when determining fit but will not try turning items on their side
 * The algorithm does consider spatial constraints in all 3 dimensions, plus consideration of weight

.. _NP-hard problem: http://en.wikipedia.org/wiki/Bin_packing_problem
