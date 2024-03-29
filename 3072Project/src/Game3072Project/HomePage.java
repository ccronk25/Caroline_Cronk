package Game3072Project;

import static Game3072Project.GamePages.BackgroundColor;
import static Game3072Project.GamePages.Color1536;
import java.awt.Color;
import java.awt.Component;
import java.awt.Font;
import javax.swing.BorderFactory;
import javax.swing.JFrame;
import javax.swing.JTextArea;

/**
 * This GUI form creates the home page.
 * The opening and running of this pages is handled in the MainProgram and
 * the other two JFrames.
 */

public class HomePage extends javax.swing.JFrame {

    //Each jframe class remembers the other active pages for efficiency and 
    //so navigating between pages doesn't make you lose game progress.
    GamePages gamePage;
    public void setGamePage(GamePages game){gamePage = game;}
    public GamePages getHomePage(){return gamePage;}
    
    
    /**
     * Creates new form HomePage
     */
    public HomePage() {
        initComponents();
        this.getContentPane().setBackground(GamePages.Color24);
        gamePage = null;
    }
    
    
    /**
     * This method is called from within the constructor to initialize the form.
     * WARNING: Do NOT modify this code. The content of this method is always
     * regenerated by the Form Editor.
     */
    @SuppressWarnings("unchecked")
    // <editor-fold defaultstate="collapsed" desc="Generated Code">//GEN-BEGIN:initComponents
    private void initComponents() {

        jLayeredPane1 = new javax.swing.JLayeredPane();
        jLabel1 = new javax.swing.JLabel();
        newGameButton = new javax.swing.JButton();
        instructionsButton = new javax.swing.JButton();
        jLabel2 = new javax.swing.JLabel();

        setDefaultCloseOperation(javax.swing.WindowConstants.EXIT_ON_CLOSE);
        setBackground(new java.awt.Color(0, 102, 0));

        jLayeredPane1.setMaximumSize(new java.awt.Dimension(1600, 900));
        jLayeredPane1.setPreferredSize(new java.awt.Dimension(1600, 900));

        jLabel1.setFont(new java.awt.Font("Bahnschrift", 0, 160)); // NOI18N
        jLabel1.setForeground(new java.awt.Color(255, 204, 204));
        jLabel1.setHorizontalAlignment(javax.swing.SwingConstants.CENTER);
        jLabel1.setText("3072");
        jLabel1.setMaximumSize(new java.awt.Dimension(600, 200));
        jLabel1.setMinimumSize(new java.awt.Dimension(78, 48));
        jLabel1.setPreferredSize(new java.awt.Dimension(400, 200));
        jLabel1.setRequestFocusEnabled(false);
        jLabel1.setVerifyInputWhenFocusTarget(false);

        newGameButton.setBackground(new java.awt.Color(241, 221, 223));
        newGameButton.setFont(new java.awt.Font("Agency FB", 0, 28)); // NOI18N
        newGameButton.setForeground(new java.awt.Color(71, 105, 48));
        newGameButton.setIcon(new javax.swing.ImageIcon(getClass().getResource("/img/NewGame.png"))); // NOI18N
        newGameButton.setBorder(null);
        newGameButton.setRolloverIcon(new javax.swing.ImageIcon(getClass().getResource("/img/NewGameRollover.png"))); // NOI18N
        newGameButton.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                newGameButtonActionPerformed(evt);
            }
        });

        instructionsButton.setBackground(new java.awt.Color(241, 221, 223));
        instructionsButton.setFont(new java.awt.Font("Agency FB", 0, 28)); // NOI18N
        instructionsButton.setForeground(new java.awt.Color(71, 105, 48));
        instructionsButton.setIcon(new javax.swing.ImageIcon(getClass().getResource("/img/Instructions.png"))); // NOI18N
        instructionsButton.setBorder(null);
        instructionsButton.setRolloverIcon(new javax.swing.ImageIcon(getClass().getResource("/img/InstructionsRollover.png"))); // NOI18N
        instructionsButton.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                instructionsButtonActionPerformed(evt);
            }
        });

        jLabel2.setIcon(new javax.swing.ImageIcon(getClass().getResource("/img/Home_Screen_Background.png"))); // NOI18N

        jLayeredPane1.setLayer(jLabel1, javax.swing.JLayeredPane.PALETTE_LAYER);
        jLayeredPane1.setLayer(newGameButton, javax.swing.JLayeredPane.DEFAULT_LAYER);
        jLayeredPane1.setLayer(instructionsButton, javax.swing.JLayeredPane.DEFAULT_LAYER);
        jLayeredPane1.setLayer(jLabel2, javax.swing.JLayeredPane.DEFAULT_LAYER);

        javax.swing.GroupLayout jLayeredPane1Layout = new javax.swing.GroupLayout(jLayeredPane1);
        jLayeredPane1.setLayout(jLayeredPane1Layout);
        jLayeredPane1Layout.setHorizontalGroup(
            jLayeredPane1Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(jLayeredPane1Layout.createSequentialGroup()
                .addContainerGap(javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                .addComponent(jLabel1, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addContainerGap(javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE))
            .addGroup(javax.swing.GroupLayout.Alignment.TRAILING, jLayeredPane1Layout.createSequentialGroup()
                .addContainerGap(681, Short.MAX_VALUE)
                .addGroup(jLayeredPane1Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.TRAILING)
                    .addComponent(instructionsButton)
                    .addComponent(newGameButton))
                .addGap(679, 679, 679))
            .addGroup(jLayeredPane1Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                .addGroup(jLayeredPane1Layout.createSequentialGroup()
                    .addGap(0, 0, Short.MAX_VALUE)
                    .addComponent(jLabel2)
                    .addGap(0, 0, Short.MAX_VALUE)))
        );
        jLayeredPane1Layout.setVerticalGroup(
            jLayeredPane1Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(jLayeredPane1Layout.createSequentialGroup()
                .addGap(236, 236, 236)
                .addComponent(jLabel1, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addGap(18, 18, 18)
                .addComponent(newGameButton, javax.swing.GroupLayout.PREFERRED_SIZE, 67, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addGap(28, 28, 28)
                .addComponent(instructionsButton, javax.swing.GroupLayout.PREFERRED_SIZE, 67, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addContainerGap(284, Short.MAX_VALUE))
            .addGroup(jLayeredPane1Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                .addGroup(jLayeredPane1Layout.createSequentialGroup()
                    .addGap(0, 0, Short.MAX_VALUE)
                    .addComponent(jLabel2)
                    .addGap(0, 0, Short.MAX_VALUE)))
        );

        javax.swing.GroupLayout layout = new javax.swing.GroupLayout(getContentPane());
        getContentPane().setLayout(layout);
        layout.setHorizontalGroup(
            layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(layout.createSequentialGroup()
                .addComponent(jLayeredPane1, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addGap(0, 0, Short.MAX_VALUE))
        );
        layout.setVerticalGroup(
            layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(layout.createSequentialGroup()
                .addComponent(jLayeredPane1, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addContainerGap(javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE))
        );

        pack();
    }// </editor-fold>//GEN-END:initComponents

    /**
     * Opens or shows a game page and hides this current page
     */
    private void newGameButtonActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_newGameButtonActionPerformed
        //only create new game page if there isn't one already
        if(gamePage==null){
             gamePage = new GamePages();
        }
        gamePage.setHomePage(this);
        
        //set game JFrame to visible and hide this one
        gamePage.setVisible(true);
        gamePage.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        this.setVisible(false);
   
        gamePage.requestFocus();
        
    }//GEN-LAST:event_newGameButtonActionPerformed

    /**
     * Displays an instructions page and hides home page 
     */
    private void instructionsButtonActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_instructionsButtonActionPerformed
        Color textColor = Color.black;

        JFrame instructionsFrame = new JFrame("Instructions For 3072");
        instructionsFrame.setSize(500, 500);
        instructionsFrame.setVisible(true);
        instructionsFrame.getContentPane().setBackground(BackgroundColor);
        instructionsFrame.setLocationRelativeTo(null); //https://www.tutorialspoint.com/how-to-display-a-jframe-to-the-center-of-a-screen-in-java#:~:text=By%20default%2C%20a%20JFrame%20can,()%20method%20of%20Window%20class.

        JTextArea instructionsTextArea = new JTextArea();
        instructionsTextArea.setFocusable(false);
        instructionsTextArea.setOpaque(false);
        instructionsTextArea.setBounds(5, 5, 200, 250); 
        instructionsTextArea.setText("Instructions for 3072:\n\n1. Move the tiles with arrow keys\n2. Combine the same number tiles \n to create a higher number\n3. Reach 3072 to win the game!");
        instructionsTextArea.setFont(new Font("Arial", Font.BOLD, 30));  
        instructionsTextArea.setForeground(textColor);
        instructionsTextArea.setAlignmentX(Component.CENTER_ALIGNMENT);
        instructionsTextArea.setBorder(BorderFactory.createLineBorder(Color1536, 3)); // add a border
        instructionsFrame.add(instructionsTextArea);
    }//GEN-LAST:event_instructionsButtonActionPerformed



    // Variables declaration - do not modify//GEN-BEGIN:variables
    private javax.swing.JButton instructionsButton;
    private javax.swing.JLabel jLabel1;
    private javax.swing.JLabel jLabel2;
    private javax.swing.JLayeredPane jLayeredPane1;
    private javax.swing.JButton newGameButton;
    // End of variables declaration//GEN-END:variables
}
