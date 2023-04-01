package candy_vending_machine;

import java.util.Scanner;

/**
 *
 * @author ccronk
 */
public class Candy_vending_machine {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        VendingMachine vendingMachine = new VendingMachine();
        
        fillVendingMachine(vendingMachine);
        
        Scanner input = new Scanner(System.in);
        String userInput = "";
        
        while(!userInput.equals("N")){
            System.out.println("\nUse candy vending machine?\n Y: Yes\n N: No (quit)");
            
            userInput = input.nextLine().trim().toUpperCase();
            
            switch (userInput) {
                case "Y":
                    while (!userInput.equals("Q")){ //based on chapter 6 stacks example
                        System.out.print(vendingMachine.DisplayContents()); 
                        System.out.println("\nEnter a slot code to select a candy or 'q' to quit:");

                        userInput = input.nextLine().trim().toUpperCase();
            
                        switch (userInput) {
                            case "A":
                                if(vendingMachine.hasItems(userInput)){
                                    vendingMachine.selectItem(userInput);
                                }
                                else{
                                    System.out.println("Slot A is empty.");
                                }
                                break;
                            case "B":
                                if(vendingMachine.hasItems(userInput)){
                                    vendingMachine.selectItem(userInput);
                                }
                                else{
                                    System.out.println("Slot B is empty.");
                                }
                                break;
                            case "C":
                                if(vendingMachine.hasItems(userInput)){
                                    vendingMachine.selectItem(userInput);
                                }
                                else{
                                    System.out.println("Slot C is empty.");
                                }
                                break;
                            case "Q":
                                break;
                            default:
                                System.out.println("Invalid input.");
                                break;  
                        }
                    }
                case "N":
                    break;
                default:
                    System.out.println("Invalid input.");
                    break;  
            }   
        }
    }
    
    /**
     * Fills the vending machine slots with preset candy
     * @param vm a (candy) vending machine
     */
    public static void fillVendingMachine(VendingMachine vm){
        Candy twix = new Candy("Twix", 1.29);
        Candy kitkat = new Candy("KitKat", 1.29);
        Candy skittles = new Candy("Skittles", 1.39);
        
        vm.addToSlot("A", twix, 3);
        vm.addToSlot("B", kitkat, 5);
        vm.addToSlot("C", skittles, 2);
    }
    
}
