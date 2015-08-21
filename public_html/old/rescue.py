from __future__ import division
import numpy as np
import scipy as sp

text = np.loadtxt('items_readable.txt')

	with open(filename) as f:
  while True:
    c = f.read(1)
    if not c:
      print "End of file"
      break
    print "Read a character:", c

# text.replace(" ","\n")

# np.savetxt('items.txt', 'hello')
