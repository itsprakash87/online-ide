												
class parent:
	sub = ""
	mark = 0
	def setmark(self,mk):
		self.mark = mk
	def getmark(self):
		return self.mark
	def setsub (self,subj):
		self.sub = subj
	def getsub(self):
		return self.sub

class child(parent):
	age = 0
	def setage(self,ag):
		self.age = ag
	def getage(self):
		return self.age

pk = parent()
pk.setmark(12)
pk.setsub("math")

pk.getmark
print(pk.getsub)										