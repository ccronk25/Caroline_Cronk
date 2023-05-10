package vending_machine;

import java.util.Scanner;

/**
 *
 * @author ccronk
 */
public class Vending_machine {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        CandyVendingMachine candyVendingMachine = new CandyVendingMachine();
        SodaVendingMachine sodaVendingMachine = new SodaVendingMachine();
        MiscVendingMachine miscVendingMachine = new MiscVendingMachine();
        
        fillCandy(candyVendingMachine);
        fillSoda(sodaVendingMachine);
        fillMisc(miscVendingMachine);
        
        Scanner input = new Scanner(System.in);
        String userInput = "";
        
        while(!userInput.equals("q")){
            System.out.println("\nChoose a vending machine, or 'q' to quit:");
            displayMachines(candyVendingMachine, sodaVendingMachine, miscVendingMachine);
            
            userInput = input.nextLine().trim().toLowerCase(); //external is lower case to differentiate
            
            switch (userInput) {
                case "1":
                    candyVendingMachine.selectSlot();
                    break;
                case "2":
                    sodaVendingMachine.selectSlot();
                    break;
                case "3":
                    miscVendingMachine.selectSlot();
                    break;
                case "q":
                    break;
                default:
                    System.out.print("Invalid input."); 
                    break;
                            
            }   
        }
    }
    
    /**
     * Fills the vending machine slots with preset candy
     * @param cvm a Candy vending machine
     */
    public static void fillCandy(CandyVendingMachine cvm){
        Candy twix = new Candy("Twix", 1.29);
        Candy kitkat = new Candy("KitKat", 1.29);
        Candy skittles = new Candy("Skittles", 1.39);
        
        cvm.addToSlot("A", twix, 3);
        cvm.addToSlot("B", kitkat, 5);
        cvm.addToSlot("C", skittles, 2);
    }
    
     /**
     * Fills the vending machine slots with preset candy
     * @param svm a Soda vending machine
     */
    public static void fillSoda(SodaVendingMachine svm){
        Soda aw = new Soda("A&W", 1.99);
        Soda grapeCrush = new Soda("Grape Crush", 1.89);
        Soda drPepper = new Soda("Dr. Pepper", 2.08);
        
        svm.addToSlot("A", aw, 3);
        svm.addToSlot("B", grapeCrush, 1);
        svm.addToSlot("C", drPepper, 4);
    }
    
      
     /**
     * Fills the vending machine slots with preset candy
     * @param mvm a vending machine that accepts IVendables
     */
    public static void fillMisc(MiscVendingMachine mvm){
        Candy starburst = new Candy("Starburst", 1.29);
        Soda fanta = new Soda("Orange Fanta", 2.29);
        StarWarsCharacter r2d2 = new StarWarsCharacter("R2-D2", null, 220.20);
        
        mvm.addToSlot("A", starburst, 5);
        mvm.addToSlot("B", fanta, 5);
        mvm.addToSlot("C", r2d2, 1);
    }
    
    
    /**
     * Displays list of vending machines
     * @param cvm a Candy vending machine
     * @param svm a Soda vending machine
     * @param mvm an IVendable vending machine
     */
    public static void displayMachines(CandyVendingMachine cvm, SodaVendingMachine svm, MiscVendingMachine mvm){
        System.out.println("1: " + cvm.GetMachineInfo());
        System.out.println("2: " + svm.GetMachineInfo());
        System.out.println("3: " + mvm.GetMachineInfo());
    }
    
}
