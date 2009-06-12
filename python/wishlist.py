# A wishlist ID (wlid) is a string consisting of characters [a-zA-Z0-9].
# Basically, it's a number in base 62.

chars = map(chr, range(ord('0'), ord('9')+1) +
                 range(ord('A'), ord('Z')+1) +
                 range(ord('a'), ord('z')+1))

num_to_char = dict(enumerate(chars))
char_to_num = dict(map(lambda (x, y): (y, x), enumerate(chars)))

def num_to_wlid(x):
    assert(type(x) == type(0) or type(x) == type(0L))
    assert(x >= 0)
    if (x < 62):
        return num_to_char[x]
    else:
        return num_to_wlid(x / 62) + num_to_char[x % 62]

def wlid_to_num(wlid):
    assert(len(wlid) > 0)
    if(len(wlid) == 1):
        return char_to_num[wlid]
    else:
        return wlid_to_num(wlid[:-1]) * 62 + char_to_num[wlid[-1]]

def test():
    i = 0L
    while i < 100000000000L:
        j = wlid_to_num(num_to_wlid(i))
        if (i != j):
            print "breaks on %d" % i
            return False
        i += 1
    return True

