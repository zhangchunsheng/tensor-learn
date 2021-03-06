import torch

# https://pytorch.org/tutorials/beginner/blitz/autograd_tutorial.html#sphx-glr-beginner-blitz-autograd-tutorial-py
x = torch.ones(2, 2, requires_grad=True)
print(x)

'''
tensor([[1., 1.],
        [1., 1.]], requires_grad=True)
'''

y = x + 2
print(y)

'''
tensor([[3., 3.],
        [3., 3.]], grad_fn=<AddBackward0>)
'''

print(y.grad_fn)
'''
<AddBackward0 object at 0x7fdcd798a518>
'''

z = y * y * 3
out = z.mean()

print(z, out)
'''
tensor([[27., 27.],
        [27., 27.]], grad_fn=<MulBackward0>) tensor(27., grad_fn=<MeanBackward0>)
'''

a = torch.randn(2, 2)
a = ((a * 3) / (a - 1))
print(a.requires_grad)
a.requires_grad_(True)
print(a.requires_grad)
b = (a * a).sum()
print(b.grad_fn)

'''
False
True
<SumBackward0 object at 0x7fdcd798a8d0>
'''

out.backward()
print(x.grad)
'''
tensor([[4.5000, 4.5000],
        [4.5000, 4.5000]])
'''

x = torch.randn(3, requires_grad=True)

y = x * 2
while y.data.norm() < 1000:
    y = y * 2

print(y)

'''
tensor([-1520.5913,   492.3205,  -107.1850], grad_fn=<MulBackward0>)
'''

v = torch.tensor([0.1, 1.0, 0.0001], dtype=torch.float)
y.backward(v)

print(x.grad)

'''
tensor([1.0240e+02, 1.0240e+03, 1.0240e-01])
'''

print(x.requires_grad)
print((x ** 2).requires_grad)

with torch.no_grad():
    print((x ** 2).requires_grad)
'''
True
True
False
'''

print(x.requires_grad)
y = x.detach()
print(y.requires_grad)
print(x.eq(y).all())
'''
True
False
tensor(True)
'''