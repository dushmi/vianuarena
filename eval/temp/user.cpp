#include<iostream>
#include<fstream>
int a,b;
using namespace std;
int main()
{
	ifstream cit("adunare.in");
	ofstream afis("adunare.out");
	cit>>a>>b;
	afis<<a+b;
	return 0;
}