//
//  WDAppDelegate.mm
//
//  Created by JAZMATI on 13/05/2013.
//  Copyright Jazmati/de l'Espinay. All rights reserved.
//

#import "WDAppDelegate.h"

void InitInstance();
void InitModule(const struct _stMyModuleInfo* pstModule);
void LoadWDLFile(NSString*);
void InitExec();
void TermExec();
extern const struct _stMyModuleInfo gstMyModuleInfo1;
void OBJ_InitIOS(UIWindow *pclWindow);
extern const struct _stMyModuleInfo gstMyModuleInfo3;
extern const struct _stMyModuleInfo gstMyModuleInfo4;
extern const struct _stMyModuleInfo gstMyModuleInfo8;
extern const struct _stMyModuleInfo gstMyModuleInfo10;
extern const struct _stMyModuleInfo gstMyModuleInfo61;
extern const struct _stMyModuleInfo gstMyModuleInfo68;


@implementation WDAppDelegate

@synthesize window; 

- (BOOL)application:(UIApplication *)application didFinishLaunchingWithOptions:(NSDictionary *)launchOptions 
{   
	CGRect screenBounds = [ [ UIScreen mainScreen ] bounds ]; 
	window = [ [ UIWindow alloc ] initWithFrame: screenBounds ];
	
	OBJ_InitIOS(window);
	InitInstance();
	InitModule(&gstMyModuleInfo1);
	InitModule(&gstMyModuleInfo3);
	InitModule(&gstMyModuleInfo4);
	InitModule(&gstMyModuleInfo8);
	InitModule(&gstMyModuleInfo10);
	InitModule(&gstMyModuleInfo61);
	InitModule(&gstMyModuleInfo68);
	InitExec();
	LoadWDLFile(@"GiteoFinal");

    
    [window makeKeyAndVisible];
    return YES;
}


- (void)applicationWillResignActive:(UIApplication *)application {
    /*
     Sent when the application is about to move from active to inactive state. This can occur for certain types of temporary interruptions (such as an incoming phone call or SMS message) or when the user quits the application and it begins the transition to the background state.
     Use this method to pause ongoing tasks, disable timers, and throttle down OpenGL ES frame rates. Games should use this method to pause the game.
     */
}


- (void)applicationDidEnterBackground:(UIApplication *)application {
    /*
     Use this method to release shared resources, save user data, invalidate timers, and store enough application state information to restore your application to its current state in case it is terminated later. 
     If your application supports background execution, called instead of applicationWillTerminate: when the user quits.
     */
}


- (void)applicationWillEnterForeground:(UIApplication *)application {
    /*
     Called as part of  transition from the background to the inactive state: here you can undo many of the changes made on entering the background.
     */
}


- (void)applicationDidBecomeActive:(UIApplication *)application {
    /*
     Restart any tasks that were paused (or not yet started) while the application was inactive. If the application was previously in the background, optionally refresh the user interface.
     */
}


- (void)applicationWillTerminate:(UIApplication *)application {
    TermExec();
}


#pragma mark -
#pragma mark Memory management

- (void)applicationDidReceiveMemoryWarning:(UIApplication *)application {
    /*
     Free up as much memory as possible by purging cached data objects that can be recreated (or reloaded from disk) later.
     */
}


- (void)dealloc {
    [window release];
    [super dealloc];
}


@end
