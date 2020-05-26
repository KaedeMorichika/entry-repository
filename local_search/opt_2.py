# セールスマン巡回問題
# 局所探索法
# 2-opt 法
#
# 2つのノードをつなぐ辺を
# 2本選び、その辺を異なる繋ぎ方に変える。
# 繋ぎかえ方は一意に定まるため、比較的容易に実装可能

import sys
import matplotlib.pyplot as plt
import random

sys.setrecursionlimit(100000)
# random.seed(0)

# 訪問先数
NUM_DESTINATION = 50

# 緯度経度（座標）
x = list(random.randrange(-10, 10) for i in range(NUM_DESTINATION - 1))
y = list(random.randrange(-10, 10) for i in range(NUM_DESTINATION - 1))
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

# 交換する道の探索範囲
def putSearchRange(i):
	a = (i + 2) % NUM_DESTINATION
	b = (i + NUM_DESTINATION - 1) % NUM_DESTINATION
	if a < b:
		return list(range(a, b))
	elif a > b:
		return list(range(0, b)) + list(range(a, NUM_DESTINATION))

# ユークリッド距離計算
# ノード n1 = (x1, y1)
# ノード n2 = (x2, y2)
def calEuclideanDistance (x1, y1, x2, y2):
	distance = pow( (x2 - x1)**2 + (y2 - y1)**2, (1/2) )
	return distance

"""
# 探索場所のコスト計算
def calStepDiff (x, y, i, j):
	 dis1 = calEuclideanDistance(x[i], y[i], x[(i+1)%NUM_DESTINATION], y[(i+1)%NUM_DESTINATION])
	 dis2 = calEuclideanDistance(x[j], y[j], x[(j+1)%NUM_DESTINATION], y[(j+1)%NUM_DESTINATION])
	 dis3 = calEuclideanDistance(x[i], y[i], x[j], y[j])
	 dis4 = calEuclideanDistance(x[(i+1)%NUM_DESTINATION], y[(i+1)%NUM_DESTINATION], x[(j+1)%NUM_DESTINATION], y[(j+1)%NUM_DESTINATION])
	 return dis3 + dis4 - dis1 - dis2
"""


# 経路前コスト計算
def calRouteCost (x, y):
	N = calEuclideanDistance(x[0], y[0], x[NUM_DESTINATION - 1], y[NUM_DESTINATION - 1])
	for i in range(NUM_DESTINATION - 1):
		N += calEuclideanDistance(x[i], y[i], x[i+1], y[i+1])
	return N

# 巡回順の変更
def swapValue (x, y, i, j, _index_):
	if (i > j):
		i, j = j, i
	x = x[0:i+1] + list(reversed(x[i+1:j])) + x[j:NUM_DESTINATION]
	y = y[0:i+1] + list(reversed(y[i+1:j])) + y[j:NUM_DESTINATION]
	_index_ = _index_[0:i+1] + list(reversed(_index_[i+1:j])) + _index_[j:NUM_DESTINATION]
	return x, y, _index_

# 近傍探索
# x : x座標配列
# y : y座標配列
# N : 前ステップの解
def localSearch (x, y, N, _index_, step):
	print('Step ' + str(step) + ' : ')
	step += 1
	for i in range(NUM_DESTINATION):
		for j in putSearchRange(i):
			"""
			diff = calStepDiff(x, y, i, j)
			if diff < 0:	
				print(diff)
				x, y, _index_ = swapValue(x, y, i, j, _index_)
				N += diff
				print (_index_)
				localSearch(x, y, N, _index_, step)
			"""
			x_star, y_star, _index_star = swapValue(x, y, i, j, _index_)
			N_star = calRouteCost(x_star, y_star)
			if N_star < N:
				print(N, N_star)
				x, y, _index_ = x_star, y_star, _index_star
				N = N_star
				return localSearch(x, y, N, _index_, step)
			
	
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
_index_, x, y, N = localSearch(x, y, N, _index_, step=0)

# 結果
print(_index_)
print(x)
print(y)
print(N)

# 結果グラフ描画
fig = plt.figure(2)
ax = fig.add_subplot(111)
ax.plot(x, y)
ax.scatter(x, y)

plt.show()