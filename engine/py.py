import math

def truncate(f, n):
    return math.floor(f * 10 ** n) / 10 ** n

n, k = map(int, input().split())
a = list(map(int, input().split()))

mn = 0

sm = sum(a[0: k])
avg = sm / (k)

l = 0
r = k - 1

while True:
    # print("l", l, "r", r, "avg", avg)
    r += 1
    if r < n:
        if a[r] >= avg:
            sm = avg*(r - l)
            avg = (sm + a[r])/(r - l + 1)
            mn = max([mn, avg])
        else:
            l += 1
            r = l + k - 1
            sm = sum(a[l: l + k])
            avg = sm /k
            mn = max([mn, avg])

    else:
        if l >= n - k + 1:
            break
        else:
            l += 1
            r = l + k - 1
            sm = sum(a[l: l + k])
            avg = sm / k
            mn = max([avg, mn])


print("{:.6f}".format(truncate(mn, 6)))
