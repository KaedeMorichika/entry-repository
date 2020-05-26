# セールスマン巡回問題
# 局所探索法
# 2

import sys
import matplotlib.pyplot as plt
import random

sys.setrecursionlimit(100000)
# random.seed(0)

# 訪問先数
NUM_DESTINATION = 50

# 緯度経度（座標）
"""
x = list(random.randrange(-10, 10) for i in range(NUM_DESTINATION - 1))
y = list(random.randrange(-10, 10) for i in range(NUM_DESTINATION - 1))
_index_ = list(range(NUM_DESTINATION - 1))
"""
x = list(range(NUM_DESTINATION - 1))
y = list(range(NUM_DESTINATION - 1))
_index_ = list(range(NUM_DESTINATION - 1))

# 入力値をシャッフル

random.shuffle(_index_)
random.shuffle(x)
random.shuffle(y)


# 先頭要素（出発地）を配列の後尾に追加
x.append(x[0])
y.append(y[0])
_index_.append(_index_[0])

step = 0

"""
関数
"""

# 交換する道の探索範囲（j）
def putSearch2ndRange(i):
	a = (i + 2) % NUM_DESTINATION
	b = (i + NUM_DESTINATION - 1) % NUM_DESTINATION
	if a < b:
		return list(range(a, b))
	elif a > b:
		return list(range(0, b)) + list(range(a, NUM_DESTINATION))

# 交換する道の探索範囲（k）
def putSearch3rdRange(i, j):
	a = (i + 2) % NUM_DESTINATION
	b = (i + NUM_DESTINATION - 1) % NUM_DESTINATION
	c = (j + 2) % NUM_DESTINATION
	d = (j + NUM_DESTINATION - 1) % NUM_DESTINATION
	if a < b:
		list_i = list(range(a, b))
	elif a > b:
		list_i = list(range(0, b)) + list(range(a, NUM_DESTINATION))
	if a < b:
		list_j = list(range(c, d))
	elif a > b:
		list_j = list(range(0, d)) + list(range(c, NUM_DESTINATION))
	list_ij = list_i + list_j
	range_list = [x for x in set(list_ij) if list_ij.count(x) > 1]
	return range_list

# ユークリッド距離計算
# ノード n1 = (x1, y1)
# ノード n2 = (x2, y2)
def calEuclideanDistance (x1, y1, x2, y2):
	distance = pow( (x2 - x1)**2 + (y2 - y1)**2, (1/2) )
	return distance

# 経路前コスト計算
def calRouteCost (x, y):
	N = calEuclideanDistance(x[0], y[0], x[NUM_DESTINATION - 1], y[NUM_DESTINATION - 1])
	for i in range(NUM_DESTINATION - 1):
		N += calEuclideanDistance(x[i], y[i], x[i+1], y[i+1])
	return N

# 巡回順の変更
def  opt_2(x, y, i, j, _index_):
	if (i > j):
		i, j = j, i
	x = x[0:i+1] + list(reversed(x[i+1:j])) + x[j:NUM_DESTINATION]
	y = y[0:i+1] + list(reversed(y[i+1:j])) + y[j:NUM_DESTINATION]
	_index_ = _index_[0:i+1] + list(reversed(_index_[i+1:j])) + _index_[j:NUM_DESTINATION]
	return x, y, _index_

def opt_3(x, y, _index_, i, j, k):
	i, j, k = sorted([i, j, k])
	N_list = []
	
	x1 = x[0:i+1] + list(reversed(x[i+1:j+1])) + list(reversed(x[j+1:k+1])) + x[k+1:NUM_DESTINATION]
	y1 = y[0:i+1] + list(reversed(y[i+1:j+1])) + list(reversed(y[j+1:k+1])) + y[k+1:NUM_DESTINATION]
	_index1_ = _index_[0:i+1] + list(reversed(_index_[i+1:j+1])) + list(reversed(_index_[j+1:k+1])) + _index_[k+1:NUM_DESTINATION]
	N1 = calRouteCost(x1, y1)
	N_list.append(N1)
	
	x2 = x[0:i+1] + list(reversed(x[j+1:k+1])) + x[i+1:j+1] + x[k+1:NUM_DESTINATION]
	y2 = y[0:i+1] + list(reversed(y[j+1:k+1])) + y[i+1:j+1] + y[k+1:NUM_DESTINATION]
	_index2_ = _index_[0:i+1] + list(reversed(_index_[j+1:k+1])) + _index_[i+1:j+1] + _index_[k+1:NUM_DESTINATION]
	N2 = calRouteCost(x2, y2)
	N_list.append(N2)
	
	x3 = x[0:i+1] + x[j+1:k+1] + x[i+1:j+1] + x[k+1:NUM_DESTINATION]
	y3 = y[0:i+1] + y[j+1:k+1] + y[i+1:j+1] + y[k+1:NUM_DESTINATION]
	_index3_ = _index_[0:i+1] + _index_[j+1:k+1] + _index_[i+1:j+1] + _index_[k+1:NUM_DESTINATION]
	N3 = calRouteCost(x3, y3)
	N_list.append(N3)
	
	x4 = x[0:i+1] + x[j+1:k+1] + list(reversed(x[i+1:j+1])) + x[k+1:NUM_DESTINATION]
	y4 = y[0:i+1] + y[j+1:k+1] + list(reversed(y[i+1:j+1])) + y[k+1:NUM_DESTINATION]
	_index4_ = _index_[0:i+1] + _index_[j+1:k+1] + list(reversed(_index_[i+1:j+1])) + _index_[k+1:NUM_DESTINATION]
	N4 = calRouteCost(x4, y4)
	N_list.append(N4)
	
	N_list.sort()
	if N_list[0] == N1:
		return N1, x1, y1, _index1_
	elif N_list[0] == N2:
		return N2, x2, y2, _index2_
	elif N_list[0] == N3:
		return N3, x3, y3, _index3_
	elif N_list[0] == N4:
		return N4, x4, y4, _index4_
	

# 近傍探索
# x : x座標配列
# y : y座標配列
# N : 前ステップの解
def localSearch (x, y, N, _index_, step, opt):
	print('Step ' + str(step) + ' : ')
	step += 1
	if opt == 2:
		for i in range(NUM_DESTINATION):
			for j in putSearch2ndRange(i):
				x_star, y_star, _index_star = opt_2(x, y, i, j, _index_)
				N_star = calRouteCost(x_star, y_star)
				if N_star < N:
					print(N, N_star)
					x, y, _index_ = x_star, y_star, _index_star
					N = N_star
					return localSearch(x, y, N, _index_, step, opt)
	if opt == 3:
		for i in range(NUM_DESTINATION):
			for j in putSearch2ndRange(i):
				for k in putSearch3rdRange(i, j):
					N_star, x_star, y_star, _index_star = opt_3(x, y, _index_, i, j, k)
					if N_star < N:
						print(N, N_star)
						x, y, _index_ = x_star, y_star, _index_star
						N = N_star
						return localSearch(x, y, N, _index_, step, opt)
	
	print ('end')
	return _index_, x, y, N

	
"""
メイン処理
"""

# 初期状態コスト計算
N = calEuclideanDistance(x[0], y[0], x[NUM_DESTINATION - 1], y[NUM_DESTINATION - 1])
for i in range(NUM_DESTINATION - 1):
	N += calEuclideanDistance(x[i], y[i], x[i+1], y[i+1])

# 初期状態グラフ描画
fig = plt.figure(1)
ax = fig.add_subplot(111)
ax.plot(x, y)
ax.scatter(x, y)

# 近傍探索
print('Local Search Start : ')
_index_, x, y, N = localSearch(x, y, N, _index_, step=0, opt=2)

# 結果グラフ描画
fig = plt.figure(2)
ax = fig.add_subplot(111)
ax.plot(x, y)
ax.scatter(x, y)

_index_, x, y, N = localSearch(x, y, N, _index_, step=0, opt=3)

# 結果
print(_index_)
print(x)
print(y)
print(N)

# 結果グラフ描画
fig = plt.figure(3)
ax = fig.add_subplot(111)
ax.plot(x, y)
ax.scatter(x, y)

plt.show()
