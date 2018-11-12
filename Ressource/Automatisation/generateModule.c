#include <stdout.h>
#include <stdlib.h>
#include <string.h>
#define MAXLENGTH 50
#define FILESCOUNT 4


char * concatenate(char * prepend, char * append){
	char * fullName = (char*) malloc(sizeof(char) * MAXLENGTH);

	strcpy(fullName, prepend);

	fullName = strcat(fullName, append);

	fullName = strcat(fullName, ".php");

	return fullName;
}


char ** getFilesName(char * moduleName){
	char ** names = (char**) malloc(sizeof(char*) * FILESCOUNT);
	
	names[0] = concatenate("mod_", moduleName);
	names[1] = concatenate("modele_", moduleName);
	names[2] = concatenate("cont_", moduleName); 
	names[3] = concatenate("vue_", moduleName);

	return names;

}

char * typeModuleName(){
	char * name = (char*) malloc(sizeof(char) * MAXLENGTH);

	printf("Nom de module : \n");

	scanf("%s", name);

	return name;
}


void upperFirstLetter(char * name){
	if(strlen(name) > 0){
		if(name[0] >= 'a' && name[0] <= 'z')
			name[0] = name[0] - 32;
	}
}

FILE * createFile(char * fileName){
	FILE* newFile = fopen(fileName, "w");

	if(newFile == NULL){
		perror("Erreur création du fichier %s", fileName);
		exit(1);
	}
	else
		return newFile;
}

void createModele(char * name,char * moduleName){
	FILE * modeleFile = createFile(name);

	fputs("<?php \n", modeleFile);
	fputs("\trequire_once 'php/verify.php; \n", modeleFile);
	fputs("\trequire_once 'php/common/Database.php;\n", modeleFile);


	fputs("\tclass Modele", modeleFile);
	fputs(upperFirstLetter(moduleName), modeleFile);
	fputs("extends Database{\n", modeleFile);

	fputs("\t\tpublic function __construct(){ }\n", modeleFile);

	fputs("\t}\n", modeleFile);
	fputs("?>", modeleFile);
}

void createCont(char * name,char * moduleName){
	FILE * contFile = createFile(name);

	fputs("<?php \n", contFile);
	
	fputs("\trequire_once  'php/verify.php; \n", contFile);
	fputs("\trequire_once __DIR__ . '/vue_ ", contFile);
	fputs(moduleName, contFile);
	fputs(".php;\n", contFile);
	fputs("\trequire_once __DIR__ . '/modele_ ", contFile);
	fputs(moduleName, contFile);
	fputs(".php;\n", contFile);

	
	fputs("\tclass Cont", contFile);
	fputs(upperFirstLetter(moduleName), contFile);
	fputs("{\n", contFile);

	
	fputs("\t\tprivate $vue; \n", contFile);
	fputs("\t\tprivate $modele; \n", contFile);


	fputs("\t\tpublic function __construct(){ \n", contFile);
	
	fputs("\t\t\t$this->vue = new Vue", contFile);
	fputs(upperFirstLetter(moduleName), contFile);
	fputs("();\n", contFile);

	fputs("\t\t\t$this->modele = new Modele", contFile);
	fputs(upperFirstLetter(moduleName), contFile);
	fputs("();\n", contFile);

	fputs("\t\t}\n", contFile);

	fputs("\t}\n", modeleFile);
	fputs("?>", modeleFile);
}


int main() {
	char * moduleName = typeModuleName();
	char ** filesName = getFilesName(moduleName);


	

}



